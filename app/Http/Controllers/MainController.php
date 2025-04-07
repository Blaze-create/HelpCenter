<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

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
            return redirect()->route($isAdmin ?  'dashboard' : 'home');
        }
        return back()->withErrors([
            'username' => 'Invalid Employee ID or password.',
        ]);
    }
    public function home()
    {
        $user = LdapUser::where('samaccountname', '=', 'c0001')->first();
        return view(
            'homepage',
            [
                'cn' => $user->getFirstAttribute('cn'),
                'email' => $user->getFirstAttribute('mail'),
            ]
        );
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
