<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->agentProfile;
        return view('agent.profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];

        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        if ($user->agentProfile) {
            $user->agentProfile->whatsapp_number = $validated['whatsapp_number'] ?? $validated['phone'];
            $user->agentProfile->save();
        }

        return back()->with('success', 'Your profile information has been updated successfully.');
    }

    public function business()
    {
        $user = Auth::user();
        $profile = $user->agentProfile;
        return view('agent.profile.business', compact('user', 'profile'));
    }

    public function requestTenderPermission(Request $request)
    {
        $user = Auth::user();
        $profile = $user->agentProfile;

        if (!$profile) {
            abort(404);
        }

        $validated = $request->validate([
            'tender_title' => 'required|string|max:255',
            'procuring_entity' => 'required|string|max:255',
            'estimated_value' => 'nullable|string|max:100',
            'justification' => 'required|string|max:2000',
        ]);

        $note = sprintf(
            "Tender Permission Request submitted on %s:\nEntity: %s\nTender: %s\nEst. Value: %s\nJustification: %s",
            now()->toDateTimeString(),
            $validated['procuring_entity'],
            $validated['tender_title'],
            $validated['estimated_value'] ?? 'N/A',
            $validated['justification']
        );

        $profile->gov_tender_permission = 'requested';
        $profile->gov_tender_notes = $profile->gov_tender_notes ? ($profile->gov_tender_notes . "\n\n" . $note) : $note;
        $profile->save();

        return back()->with('success', 'Your Government Tender authorization request has been submitted to Aura Soaps Management for official review.');
    }
}
