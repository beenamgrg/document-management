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

    //Access for Login Page
    public function index()
    {
        try
        {
            if (Auth::check())
            {
                return redirect()->intended('/dashboard/index');
            }
            return view('login.index');
        }
        catch (Exception $e)
        {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    //Access for the sign-up page
    public function signUp()
    {
        try
        {
            if (Auth::check())
            {
                return redirect()->intended('/dashboard/index');
            }
            return view('sign-up.index');
        }
        catch (Exception $e)
        {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    //Login Function
    public function login(Request $request)
    {
        try
        {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails())
            {
                Session::flash('warning', 'Invalid Credentials');
                return redirect()->back()
                    ->withInput($request->input());
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            {
                if (Auth::User()->status != 1)
                {
                    Auth::logout();
                    Session::flash('error', 'Your account is not activated yet.');
                    return redirect()->back()->withInput($request->input());
                }
                Session::flash('success', 'Logged in Successfully.');
                return redirect()->route('dashboard.index');
            }
            else
            {
                Session::flash('error', 'Invalid credentials Given.');
                return redirect()->back()->withInput($request->input());
            }
        }
        catch (Exception $e)
        {
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput($request->input())
                ->withErrors($validator->errors());
        }
    }

    //Logout Function
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flash('success', 'Logged out Succesfully.');
        return redirect()->route('index');
    }

    //Sign-up Function
    public function userRegister(Request $request)
    {
        DB::beginTransaction();
        try
        {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);
            if ($validator->fails())
            {
                Session::flash('warning', $validator->errors()->all());
                return redirect()->back()
                    ->withInput($request->input());
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = hash::make($request->password);
            $user->save();
            Auth::login($user);
            DB::commit();
            Session::flash('success', 'Registration Successfull. You are now logged in.');
            return redirect()->route('dashboard.index');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput($request->input());
        }
    }
}
