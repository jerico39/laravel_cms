<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberRegisteredUserController extends Controller
{
    /**
     * Where to redirect users after registration.
     */
    protected string $redirectTo = '/member/register/complete';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['showRegistrationForm', 'confirmRegistration', 'completeRegistration']);
    }

    public function showRegistrationForm()
    {
        return view('auth.member.register');
    }

    public function confirmRegistration(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

        return view('auth.member.confirm', compact('validated'));
    }

    public function completeRegistration(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

        $member = $this->create($validated);

        return view('auth.member.complete', compact('member'));
    }

    public function showCompletionPage()
    {
        $member = session('member');

        return view('auth.member.complete', compact('member'));
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new member instance after a valid registration.
     */
    protected function create(array $data)
    {
        return Member::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}