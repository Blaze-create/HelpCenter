<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\internalUser;
use App\Models\issueType;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $currentUser = session('samaccountname');
        $user = internalUser::where('samaccountname', $currentUser)->first();
        if (!$user) {
            return redirect()->route('home');
        }
        if ($user->role !== 'Admins') {
            return redirect()->route('dashboard');
        }
        $isAdmin = $user->role === 'Admins';

        $users = internalUser::all();
        $user_cn = [];

        $samaccounts = internalUser::pluck('samaccountname')->unique();

        $ticketCounts = Ticket::whereIn('assigned_to', $samaccounts)
            ->whereIn('status', ['open', 'in_progress'])
            ->select('assigned_to', DB::raw('count(*) as total'))
            ->groupBy('assigned_to')
            ->pluck('total', 'assigned_to');

        foreach ($samaccounts as $samaccount) {
            if (!isset($ticketCounts[$samaccount])) {
                $ticketCounts[$samaccount] = 0; // Default to 0 if no tickets for this user
            }
        }
        foreach ($samaccounts as $sam) {
            $commonname = LdapUser::where('samaccountname', '=', $sam)->first();

            if ($commonname) {
                $user_cn[] = [
                    'samaccountname' => $sam,
                    'cn' => $commonname->cn[0] ?? 'N/A',
                    'mail' => $commonname->mail[0] ?? 'N/A',
                    'title' => $commonname->title[0] ?? 'N/A',
                    'department' => $commonname->department[0] ?? 'N/A'
                ];
            }
        }

        $issueType = issueType::all();

        return view(
            'admin.user',
            [
                'users' => $users,
                'user_cn' => $user_cn,
                'ticketCounts' => $ticketCounts,
                'userRole' => $isAdmin,
                'issues' => $issueType,
            ]
        );
    }

    public function getUser($filter)
    // AJAX FETCH
    {
        $filter = trim($filter);

        $results = LdapUser::rawFilter("(|(cn=*{$filter}*)(samaccountname=*{$filter}*))")->get();

        $users = $results->map(function ($user) {
            return [
                'cn' => $user->getFirstAttribute('cn'),
                'samaccountname' => $user->getFirstAttribute('samaccountname'),
            ];
        });
        return response()->json($users);
    }



    public function addUser(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'type' => 'required|string',
            'role' => 'required|string'
        ]);

        if (internalUser::where('samaccountname', $validated['username'])->exists()) {
            return redirect()->back()->with('message', ' User already Exists')->with('status', 'Errors');
        }

        internalUser::create([
            'samaccountname' => $validated['username'],
            'type' => $validated['type'],
            'role' => $validated['role']
        ]);
        return redirect()->back()->with('message', 'User Added Successfully');
    }
    public function getUserData($id)
    {
        $user = internalUser::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }

        $samaccountname = $user->samaccountname;

        $user = LdapUser::where('samaccountname', $samaccountname)->first();

        $activeCount = Ticket::where('assigned_to', $samaccountname)
            ->whereIn('status', ['open', 'in_progress'])
            ->count();
        $closedCount = Ticket::where('samaccountname', $samaccountname)
            ->where('status', 'closed')
            ->count();
        return response()->json([
            'active' => $activeCount,
            'closed' => $closedCount,
            'mail' => $user->getAttribute('mail')[0] ?? 'N/A',
        ]);
    }
}
