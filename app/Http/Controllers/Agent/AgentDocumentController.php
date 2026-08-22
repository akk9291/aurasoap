<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgentDocumentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->agentProfile;

        return view('agent.documents.index', compact('user', 'profile'));
    }

    public function download($type)
    {
        $user = Auth::user();
        $profile = $user->agentProfile;

        if (!$profile) {
            abort(404);
        }

        $filePath = match ($type) {
            'business_reg' => $profile->business_reg_doc,
            'id_card' => $profile->id_card_doc,
            'agreement' => $profile->agreement_doc,
            default => null,
        };

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'Document file is currently unavailable or being processed by Aura Soaps Management.');
        }

        return Storage::disk('public')->download($filePath);
    }
}
