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
        $currentUser = session('samaccountname');
        $user = internalUser::where('samaccountname', $currentUser)->first();
        $isAdmin = $user->role === 'Admins';

        // Get tickets based on user role
        $ticketsQuery = Ticket::whereIn('status', ['open', 'in_progress'])
            ->orderByRaw("FIELD(status, 'open', 'in_progress')");

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

        // Get technicians
        // TODO: REfactor code  to use sql instead of ldap
        // FIXME:
        $technicians = LdapUser::where('title', 'Technicians')->get()->map(function ($user) {
            return [
                'cn' => $user->cn[0] ?? null,
                'samaccountname' => $user->samaccountname[0] ?? null,
            ];
        });

        return view('admin.dashboard', [
            'samaccounts' => $relevantSamaccounts,
            'user_cn' => $userDetails,
            'ongoing_tickets' => $tickets,
            'technicians' => $technicians,
            'issueTypes' => $issueTypes,
            'userRole' => $isAdmin,
        ]);
    }
}
