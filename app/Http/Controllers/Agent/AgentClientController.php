<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentClientController extends Controller
{
    public function index(Request $request)
    {
        $query = AgentClient::where('user_id', Auth::id());

        if ($request->filled('type')) {
            $query->where('client_type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $clients = $query->withCount(['orders', 'enquiries'])->latest()->paginate(10)->withQueryString();

        return view('agent.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('agent.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'client_type' => 'required|in:wholesaler,retailer',
            'phone' => 'required|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'notes' => 'nullable|string|max:2000',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['user_id'] = Auth::id();

        $client = AgentClient::create($validated);

        return redirect()->route('agent.clients.show', $client)->with('success', 'Buyer client added successfully.');
    }

    public function show(AgentClient $client)
    {
        // Enforce data isolation: agent can only view their own client
        if ($client->user_id !== Auth::id()) {
            abort(403, 'Unauthorized. You can only view your own clients.');
        }

        $client->load(['enquiries' => fn($q) => $q->latest(), 'orders' => fn($q) => $q->latest()]);

        return view('agent.clients.show', compact('client'));
    }

    public function edit(AgentClient $client)
    {
        if ($client->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        return view('agent.clients.edit', compact('client'));
    }

    public function update(Request $request, AgentClient $client)
    {
        if ($client->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'client_type' => 'required|in:wholesaler,retailer',
            'phone' => 'required|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'notes' => 'nullable|string|max:2000',
            'status' => 'required|in:active,inactive',
        ]);

        $client->update($validated);

        return redirect()->route('agent.clients.show', $client)->with('success', 'Client details updated successfully.');
    }

    public function destroy(AgentClient $client)
    {
        if ($client->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $client->delete();

        return redirect()->route('agent.clients.index')->with('success', 'Client record removed successfully.');
    }
}
