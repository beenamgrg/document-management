<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class SessionController extends Controller
{

    public function index()
    {
        try
        {
            return view('login.index');
        }
        catch (Exception $e)
        {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function login(Request $request)
    {
        try
        {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails())
            {
                Session::flash('warning', 'Email and password are required.');
                return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator->errors());
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            {
                if (Auth::User()->status != 1)
                {
                    Auth::logout();
                    Session::flash('error', 'Your account is not activated yet.');
                    return redirect()->back()->withInput($request->input());
                }
                Session::flash('success', 'Login Success.');
            }
            else
            {
                Session::flash('error', 'Invalid credentials Given.');
                return redirect()->back()->withInput($request->input());
            }
        }
        catch (Exception $e)
        {
            Session::flash('error', 'Something went wrong. Please try again !');
            return redirect()->back()->withInput($request->input())
                ->withErrors($validator->errors());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flash('success', 'Logged out Succesfully.');
        return redirect()->route('home');
    }
}
