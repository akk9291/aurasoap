<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentClient;
use App\Models\AgentEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = AgentEnquiry::with('client')->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('product_interests', 'like', "%{$search}%");
            });
        }

        $enquiries = $query->latest()->paginate(10)->withQueryString();

        return view('agent.enquiries.index', compact('enquiries'));
    }

    public function create(Request $request)
    {
        $clients = AgentClient::where('user_id', Auth::id())->where('status', 'active')->orderBy('name')->get();
        $selectedClientId = $request->query('client_id');

        return view('agent.enquiries.create', compact('clients', 'selectedClientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|exists:agent_clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'product_interests' => 'nullable|string|max:255',
            'estimated_quantity' => 'nullable|string|max:255',
            'status' => 'required|in:new,contacted,follow_up,converted,closed',
            'notes' => 'nullable|string|max:2000',
        ]);

        // Security check: if client_id provided, ensure it belongs to this agent
        if (!empty($validated['client_id'])) {
            $client = AgentClient::where('id', $validated['client_id'])->where('user_id', Auth::id())->first();
            if (!$client) {
                abort(403, 'Invalid client selected.');
            }
        }

        $validated['user_id'] = Auth::id();

        $enquiry = AgentEnquiry::create($validated);

        return redirect()->route('agent.enquiries.show', $enquiry)->with('success', 'Enquiry recorded successfully.');
    }

    public function show(AgentEnquiry $enquiry)
    {
        if ($enquiry->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $enquiry->load('client');

        return view('agent.enquiries.show', compact('enquiry'));
    }

    public function updateStatus(Request $request, AgentEnquiry $enquiry)
    {
        if ($enquiry->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'status' => 'required|in:new,contacted,follow_up,converted,closed',
            'notes' => 'nullable|string|max:2000',
        ]);

        $enquiry->status = $validated['status'];
        if (!empty($validated['notes'])) {
            $enquiry->notes = $enquiry->notes ? ($enquiry->notes . "\n" . date('Y-m-d H:i') . ": " . $validated['notes']) : (date('Y-m-d H:i') . ": " . $validated['notes']);
        }
        $enquiry->save();

        return back()->with('success', 'Enquiry status updated successfully.');
    }

    public function destroy(AgentEnquiry $enquiry)
    {
        if ($enquiry->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $enquiry->delete();

        return redirect()->route('agent.enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }
}
