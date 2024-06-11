<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Models\User;


class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        DB::beginTransaction();
        try
        {
            $google_user = Socialite::driver('google')->user();
            //check if user already exsists
            $user = User::where('google_id', $google_user->id)->first();
            if (!$user)
            {
                $new_user = new User();
                $new_user->name = $google_user->name;
                $new_user->email = $google_user->email;
                $new_user->google_id = $google_user->id;
                $new_user->save();
                Auth::login($new_user);
            }
            else
            {
                // Login the user
                Auth::login($user);
            }
            // dd($google_user);
            DB::commit();
            Session::flash('success', 'Logged in Successfully.');
            return redirect()->intended('dashboard/index');
        }
        catch (Exception $e)
        {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
