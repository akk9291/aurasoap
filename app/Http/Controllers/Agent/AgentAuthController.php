<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AgentAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAgent()) {
            if (Auth::user()->agentProfile && Auth::user()->agentProfile->isApproved()) {
                return redirect()->route('agent.dashboard');
            }
            return redirect()->route('agent.pending-status');
        }
        return view('agent.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (!$user->isAgent()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'The provided account is not registered as a Principal Agent.',
                ])->onlyInput('email');
            }

            $profile = $user->agentProfile;

            if ($profile && $profile->isSuspended()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your Principal Agent account has been suspended. Please contact Aura Soaps Management.',
                ])->onlyInput('email');
            }

            if ($profile && $profile->application_status === 'rejected') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your Principal Agent application was not approved. Please contact Aura Soaps Management.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            if ($profile && $profile->isApproved()) {
                return redirect()->intended(route('agent.dashboard'));
            }

            return redirect()->route('agent.pending-status');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('agent.login')->with('success', 'You have been logged out securely.');
    }

    public function showRegister()
    {
        if (Auth::check() && Auth::user()->isAgent()) {
            return redirect()->route('agent.dashboard');
        }
        return view('agent.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            // Personal Information
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'national_id_number' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed',

            // Business Information
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|in:wholesaler,retailer,distributor,independent_agent',
            'business_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province_state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'business_details' => 'nullable|string|max:2000',
            'buyer_network_info' => 'nullable|string|max:2000',

            // Distribution Requirements
            'expected_order_volume' => 'required|string|max:255',
            'distribution_requirements' => 'nullable|string|max:2000',

            // Document Uploads
            'business_reg_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'id_card_doc' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',

            // Terms & Tender Restriction
            'accept_terms' => 'required|accepted',
            'acknowledge_tender_restriction' => 'required|accepted',
        ], [
            'acknowledge_tender_restriction.accepted' => 'You must acknowledge that participating in government tenders without prior written approval from Aura Soaps Management is strictly prohibited.',
        ]);

        // Upload documents if present
        $businessRegPath = null;
        if ($request->hasFile('business_reg_doc')) {
            $businessRegPath = $request->file('business_reg_doc')->store('agent_docs/business_reg', 'public');
        }

        $idCardPath = null;
        if ($request->hasFile('id_card_doc')) {
            $idCardPath = $request->file('id_card_doc')->store('agent_docs/id_cards', 'public');
        }

        // Create User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        // Attach Principal Agent role
        $role = Role::firstOrCreate(
            ['slug' => 'principal-agent'],
            ['name' => 'Principal Agent', 'description' => 'Aura Soaps approved regional or national principal agent.']
        );
        $user->roles()->syncWithoutDetaching([$role->id]);

        // Create Agent Profile
        AgentProfile::create([
            'user_id' => $user->id,
            'company_name' => $validated['company_name'],
            'business_type' => $validated['business_type'],
            'business_address' => $validated['business_address'],
            'city' => $validated['city'],
            'province_state' => $validated['province_state'] ?? null,
            'country' => $validated['country'],
            'whatsapp_number' => $validated['whatsapp_number'] ?? $validated['phone'],
            'national_id_number' => $validated['national_id_number'],
            'business_details' => $validated['business_details'] ?? null,
            'buyer_network_info' => $validated['buyer_network_info'] ?? null,
            'expected_order_volume' => $validated['expected_order_volume'],
            'distribution_requirements' => $validated['distribution_requirements'] ?? null,
            'business_reg_doc' => $businessRegPath,
            'id_card_doc' => $idCardPath,
            'application_status' => 'pending',
            'gov_tender_permission' => 'not_permitted',
        ]);

        // Log in user to show pending screen
        Auth::login($user);

        return redirect()->route('agent.pending-status')->with('success', 'Your Principal Agent application has been submitted successfully and is now under review by Aura Soaps Management.');
    }

    public function pendingStatus()
    {
        if (!Auth::check()) {
            return redirect()->route('agent.login');
        }

        $user = Auth::user();
        $profile = $user->agentProfile;

        if ($profile && $profile->isApproved()) {
            return redirect()->route('agent.dashboard');
        }

        return view('agent.auth.pending-status', compact('user', 'profile'));
    }

    public function showForgotPassword()
    {
        return view('agent.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('status', __($status));
    }

    public function showResetPassword(Request $request, $token = null)
    {
        return view('agent.auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('agent.login')->with('success', 'Your password has been reset successfully. Please log in.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
