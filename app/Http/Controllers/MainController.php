<?php

namespace App\Http\Controllers;

use App\Models\internalUser;
use App\Models\issueType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

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
            session([
                'samaccountname' => $request->input('username'),
            ]);
            $user = internalUser::where('samaccountname', $request->input('username'))->first();
            if ($user) {
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
    public function destroy()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('index');
    }
}
