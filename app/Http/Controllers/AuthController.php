<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function failed()
    {
        return view('failed');
    }

    public function login(Request $request)
    {

        $request->validate([
            'ip' => 'required',
            'username' => 'required',
        ]);

        $ip = $request->post('ip');
        $username = $request->post('username');
        $password = $request->post('password');

        $data = [
            'ip' => $ip,
            'username' => $username,
            'password' => $password,

        ];



        $request->session()->put($data);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        return redirect('login');
    }
}