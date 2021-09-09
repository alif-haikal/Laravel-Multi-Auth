<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\User;


class AuthController extends Controller
{
    public function showFormLogin()
    {
        // if (Auth::check() && Auth::user()->status == '1') {
        //     return redirect()->route('home');
        // }
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];

        $messages = [
            'email.required'        => 'Email is compulsary',
            'email.email'           => 'Email not valid',
            'password.required'     => 'Password is compulsary',
            'password.string'       => 'Password must be string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        Auth::attempt($data);

        // if (Auth::check() && Auth::user()->status == '1') {
        //     return redirect()->route('home');
        // } else if(Auth::check() && Auth::user()->status == '0'){
        //     Auth::logout();
        //     Session::flash('error', 'Your Account Has Been Disable. Please Contact Admin');
        //     return redirect()->route('login');
        // }else {
        //     Session::flash('error', 'Email or password incorrect');
        //     return redirect()->route('login');
        // }
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            Session::flash('error', 'Email or password incorrect');
            return redirect()->route('login');
        }
    }

    public function showFormRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed'
        ];

        $messages = [
            'name.required'         => 'Name is compulsary',
            'name.min'              => 'Nama minimum 3 character',
            'name.max'              => 'Nama maximum 35 character',
            'email.required'        => 'Email is compulsary',
            'email.email'           => 'Email is not valid',
            'email.unique'          => 'Email is registered!',
            'password.required'     => 'Password is compulsary',
            'password.confirmed'    => 'Password is not same'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->status = 1;
        $user->is_admin = 0;
        $simpan = $user->save();

        if ($simpan) {
            Session::flash('success', 'Register success. Please Login!');
            return redirect()->route('login');
        } else {
            Session::flash('errors', ['' => 'Register fail! Please try again']);
            return redirect()->route('register');
        }
    }

    public function logout()
    {
        Auth::logout(); // delete session yang aktif
        return redirect()->route('login');
    }
}
