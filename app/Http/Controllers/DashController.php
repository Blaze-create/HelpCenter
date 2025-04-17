<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\internalUser;
use App\Models\issueType;
use App\Models\Ticket;

use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class DashController extends Controller
{
    public function index(Request $request, $filter = null)
    {
        $currentUser = session('samaccountname');
        $user = internalUser::where('samaccountname', $currentUser)->first();
        if (!$user) {
            return redirect()->route('home');
        }
        $isAdmin = $user->role === 'Admins';


        // Get tickets based on user role
        $ticketsQuery = Ticket::whereIn('status', ['open', 'in_progress']);

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $ticketsQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhere('priority', 'like', "%{$searchTerm}%")
                    ->orWhere('category', 'like', "%{$searchTerm}%");
            });
        }

        switch ($request->filter) {
            case 'date_asc':
                $ticketsQuery->orderBy('created_at', 'asc');
                break;
            case 'date_desc':
                $ticketsQuery->orderBy('created_at', 'desc');
                break;
            case 'priority':
                $ticketsQuery->orderByRaw("FIELD(priority, 'critical', 'high', 'medium', 'low')");
                break;
            default:
                $ticketsQuery->orderByRaw("FIELD(status, 'open', 'in_progress')");
                break;
        }

        $tickets = $isAdmin
            ? $ticketsQuery->get()
            : $ticketsQuery->where('assigned_to', $currentUser)->get();

        // Get all ticket samaccountnames based on user role
        $relevantSamaccounts = $isAdmin
            ? Ticket::pluck('samaccountname')->unique()
            : Ticket::where('assigned_to', $currentUser)->pluck('samaccountname')->unique();

        // Get LDAP tickets user details
        $userDetails = [];
        foreach ($relevantSamaccounts as $sam) {
            $ldapUser = LdapUser::where('samaccountname', $sam)->first();
            if ($ldapUser) {
                $userDetails[] = [
                    'samaccountname' => $sam,
                    'cn' => $ldapUser->cn[0] ?? 'N/A',
                    'mail' => $ldapUser->mail[0] ?? 'N/A',
                    'title' => $ldapUser->title[0] ?? 'N/A',
                    'department' => $ldapUser->department[0] ?? 'N/A',
                ];
            }
        }
        // Get all issue types
        $issueTypes = issueType::all();

        $tech = internalUser::where('role', 'Technicians')->pluck('samaccountname');
        $techDetail = [];
        foreach ($tech as $sam) {
            $ldapUser = LdapUser::where('samaccountname', $sam)->first();
            if ($ldapUser) {
                $techDetail[] = [
                    'samaccountname' => $sam,
                    'cn' => $ldapUser->cn[0] ?? 'N/A',
                    'mail' => $ldapUser->mail[0] ?? 'N/A',
                    'title' => $ldapUser->title[0] ?? 'N/A',
                    'department' => $ldapUser->department[0] ?? 'N/A',
                ];
            }
        }

        return view('admin.dashboard', [
            'user_cn' => $userDetails,
            'ongoing_tickets' => $tickets,
            'issueTypes' => $issueTypes,
            'userRole' => $isAdmin,
            'techDetail' => $techDetail,
        ]);
    }
    function updateTicket(Request $request, $id)
    {
        $record = Ticket::findOrFail($id);

        $fields = ['category', 'priority', 'assigned_to', 'status'];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $record->$field = $request->input($field);
            }
        }
        $record->save();
        return back()->with('message', 'Ticket updated successfully');
    }
}
