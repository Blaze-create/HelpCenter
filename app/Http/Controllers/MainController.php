<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use App\Models\Ticket;

class MainController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function login(Request $request)
    {
        $credentials = [
            'samaccountname' => $request->input('username'),
            'password' => $request->input('password'),
        ];
        if (Auth::attempt($credentials)) {
            /** @var LdapUser $user */
            $user = Auth::user();
            $isAdmin = collect($user->getAttribute('memberof'))
                ->contains(function ($groupDn) {
                    return str_contains($groupDn, 'CN=Domain Admins');
                });


            session([
                'samaccountname' => $request->input('username'),
            ]);

            if ($isAdmin) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home');
            }
        }
        return back()->withErrors([
            'username' => 'Invalid Employee ID or password.',
        ]);
    }
    public function home()
    {
        $user = LdapUser::where('samaccountname', '=', session('samaccountname'))->first();

        $cn = $user->getAttribute('cn')[0];

        // preg_match('/CN=([^,]+)/', $cn, $matches);
        // $cn = $matches[1] ?? null;

        $ticket = Ticket::where('samaccountname', session('samaccountname'))->orderBy('created_at', 'desc')->get();


        return view(
            'homepage',
            [
                'tickets' => $ticket,
                'cn' => $cn
            ]
        );
    }

    public function submit_ticket(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|file|mimes:png,jpg,jpeg,pdf|max:2048'
        ]);
        $path = null;

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }



        Ticket::create([
            'samaccountname' => session('samaccountname'),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'attachment' => $path,
            'assigned_to' => 'unassigned',
            'priority' => 'unassigned',
            'category' => 'unassigned',
            'resolved_at' => null,
            'notes' => null,
            'status' => 'open',
        ]);
        return redirect()->back()->with('message', 'Ticket submitted successfully!');
    }
    public function dashboard()
    {
        $tickets = Ticket::whereIn('status', ['open', 'in_progress'])
            ->orderByRaw("FIELD(status, 'open', 'in_progress')")
            ->get();

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




        return view(
            'admin.dashboard',
            [
                'samaccounts' => $samaccounts,
                'user_cn' => $user_cn,
                'ongoing_tickets' => $tickets
            ]
        );
    }
    public function destroy()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('index');
    }
}
