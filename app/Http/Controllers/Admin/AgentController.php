<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = Agent::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('city_town', 'like', "%{$search}%")
                  ->orWhere('province_state', 'like', "%{$search}%");
            });
        }

        if ($request->filled('country') && $request->country !== 'all') {
            $query->where('country', $request->country);
        }

        $agents = $query->orderBy('sort_order')->paginate(15)->withQueryString();

        return view('admin.agents.index', compact('agents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'market' => 'required|string|in:rwanda,regional',
            'country' => 'required|string|in:rwanda,drc,uganda,tanzania',
            'city_town' => 'required|string|max:255',
            'province_state' => 'required|string|max:255',
            'agent_count' => 'required|integer|min:1',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status');

        Agent::create($validated);

        return redirect()->route('admin.agents.index')->with('success', 'Principal Agent location added successfully.');
    }

    public function update(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'market' => 'required|string|in:rwanda,regional',
            'country' => 'required|string|in:rwanda,drc,uganda,tanzania',
            'city_town' => 'required|string|max:255',
            'province_state' => 'required|string|max:255',
            'agent_count' => 'required|integer|min:1',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status');

        $agent->update($validated);

        return redirect()->route('admin.agents.index')->with('success', 'Agent location updated successfully.');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();

        return redirect()->route('admin.agents.index')->with('success', 'Agent location deleted successfully.');
    }
}
