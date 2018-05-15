<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;

class UserController extends Controller
{

    /**
     * Create a new User Controller instance.
     *
     * @return void
     */
    public function __construct(User $user = null)
    {
        $this->middleware(['auth', 'allow'], ['admin', ['except' => ['edit', 'update']]]);

        $this->user = $user;
    }

    /**
     * Display a listing of All Users (No Admin Status)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Non-Administrator Users */
        $users = $this->user->get_non_admin_users();
        return view('auth.users', compact('users'));
    }

    /**
     * Display User (No Admin Status)
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('auth.show', compact('user'));
    }

    /**
     * Show the form for editing User
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->id == $user->id) {
            Log::info('Showing User Profile for User ID: ' . $user->id . ', Name: ' . $user->name);
            return view('auth.edit', compact('user'));
        }

        return redirect('home');
    }

    /**
     * Update User.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User                $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $this->validate(
            $request,
            [
                'name' => 'filled|alpha_spaces|max:255',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
                'email' => "filled|email|min:10|max:255|unique:users,email,{$user->id}",
                'phone' => 'digits_between:6,30',
            ]
        );

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if (!$request->input('password') == '') {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();
        $request->session()->flash('message', 'Podaci su uspešno izmenjeni.');
        Log::info('Update user profile for user: ' . $user->id);
        return back();
    }

    /**
     * Change User Status On Authorized (No Admin Status)
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function authorized(User $user)
    {
        $user->update(['is_unauthorized' => 0]);
        Session::flash('message', 'Korisniku je omogućen pristup.');
        return back();
    }

    /**
     * Change User Status On Unauthorized (No Admin Status)
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function unauthorized(User $user)
    {
        $user->update(['is_unauthorized' => 1]);
        Session::flash('message', 'Korisniku je onemogućen pristup!');
        return back();
    }

    /**
     * Delete User (No Admin Status)
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        Session::flash('message', 'Korisnik ' . $user->name . ' je obrisan!');
        return redirect('users');
    }
}
