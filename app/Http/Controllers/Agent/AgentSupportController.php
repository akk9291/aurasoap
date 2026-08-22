<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentSupportMessage;
use App\Models\AgentSupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentSupportController extends Controller
{
    public function index(Request $request)
    {
        $query = AgentSupportTicket::withCount('messages')->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest('updated_at')->paginate(10)->withQueryString();

        return view('agent.support.index', compact('tickets'));
    }

    public function create()
    {
        return view('agent.support.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,normal,high,urgent',
            'message' => 'required|string|max:4000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx,zip|max:10240',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('support_attachments', 'public');
        }

        $ticket = AgentSupportTicket::create([
            'ticket_number' => AgentSupportTicket::generateTicketNumber(),
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'priority' => $validated['priority'],
            'status' => 'open',
            'last_reply_at' => now(),
        ]);

        AgentSupportMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'is_admin_reply' => false,
            'message' => $validated['message'],
            'attachment_path' => $attachmentPath,
        ]);

        return redirect()->route('agent.support.show', $ticket)->with('success', 'Support ticket ' . $ticket->ticket_number . ' created. Management has been notified.');
    }

    public function show(AgentSupportTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $ticket->load(['messages.user']);

        return view('agent.support.show', compact('ticket'));
    }

    public function reply(Request $request, AgentSupportTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        if ($ticket->status === 'closed') {
            return back()->with('error', 'This ticket is closed. Please create a new ticket.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:4000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx,zip|max:10240',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('support_attachments', 'public');
        }

        AgentSupportMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'is_admin_reply' => false,
            'message' => $validated['message'],
            'attachment_path' => $attachmentPath,
        ]);

        $ticket->status = 'open';
        $ticket->last_reply_at = now();
        $ticket->save();

        return back()->with('success', 'Your reply has been sent to Aura Soaps Support.');
    }
}
