<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\internalUser;
use App\Models\issueType;
use App\Models\Ticket;

use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class DashController extends Controller
{
    public function index($filter = null)
    {
        // Check User role from internalUser table and give the user ticket depending on their role
        $userType = internalUser::where('samaccountname', session('samaccountname'))->first();
        if ($userType->role == 'Admins') {
            $tickets = Ticket::whereIn('status', ['open', 'in_progress'])
                ->orderByRaw("FIELD(status, 'open', 'in_progress')")
                ->get();
            // -------------------------------------------------------------
            $samaccounts = Ticket::pluck('samaccountname')->unique();
        } else {
            $tickets = Ticket::whereIn('status', ['open', 'in_progress'])
                ->where('assigned_to', session('samaccountname'))
                ->orderByRaw("FIELD(status, 'open', 'in_progress')")
                ->get();
            // -------------------------------------------------------------
            $samaccounts = Ticket::where('assigned_to', session('samaccountname'))
                ->pluck('samaccountname')
                ->unique();
        }
        $userRole = $userType->role == 'Admins' ? true : false;
        $issueType = issueType::all();

        $user_cn = [];
        $samaccounts = Ticket::pluck('samaccountname')->unique();
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

        $technicians = LdapUser::where('title', '=', 'Technicians')->get();
        $techniciansData = $technicians->map(function ($user) {
            return [
                'cn' => $user->cn[0] ?? null,
                'samaccountname' => $user->samaccountname[0] ?? null,
            ];
        });
        return view(
            'admin.dashboard',
            [
                'samaccounts' => $samaccounts,
                'user_cn' => $user_cn,
                'ongoing_tickets' => $tickets,
                'technicians' => $techniciansData,
                'issueTypes' => $issueType,
                'userRole' => $userRole,
            ]
        );
    }
}
