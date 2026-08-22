<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentMarketingMaterial;
use App\Models\AgentOrder;
use App\Models\AgentProfile;
use App\Models\AgentSupportMessage;
use App\Models\AgentSupportTicket;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminAgentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = AgentProfile::with(['user', 'approvedBy']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('application_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('agent_code', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $agents = $query->latest()->paginate(12)->withQueryString();

        // Counts for tab badges
        $counts = [
            'all' => AgentProfile::count(),
            'pending' => AgentProfile::where('application_status', 'pending')->count(),
            'under_review' => AgentProfile::where('application_status', 'under_review')->count(),
            'approved' => AgentProfile::where('application_status', 'approved')->count(),
            'rejected' => AgentProfile::where('application_status', 'rejected')->count(),
            'suspended' => AgentProfile::where('application_status', 'suspended')->count(),
        ];

        return view('admin.agent_management.index', compact('agents', 'counts'));
    }

    public function show(AgentProfile $agent)
    {
        $agent->load(['user', 'approvedBy']);
        
        $user = $agent->user;
        $clients = $user ? $user->agentClients()->withCount('orders')->latest()->take(10)->get() : collect();
        $enquiries = $user ? $user->agentEnquiries()->latest()->take(10)->get() : collect();
        $orders = $user ? $user->agentOrders()->with('client')->latest()->take(10)->get() : collect();
        $tickets = $user ? $user->agentTickets()->latest()->take(5)->get() : collect();

        return view('admin.agent_management.show', compact('agent', 'user', 'clients', 'enquiries', 'orders', 'tickets'));
    }

    public function approve(Request $request, AgentProfile $agent)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        return DB::transaction(function () use ($agent, $request) {
            // Generate unique Agent ID if not set
            if (!$agent->agent_code) {
                $count = AgentProfile::whereNotNull('agent_code')->count() + 1001;
                $agent->agent_code = 'AS-AGT-' . $count;
            }

            $agent->application_status = 'approved';
            $agent->approved_at = now();
            $agent->approved_by = Auth::id();
            if ($request->filled('admin_notes')) {
                $agent->admin_internal_notes = $agent->admin_internal_notes ? ($agent->admin_internal_notes . "\n" . date('Y-m-d') . ": " . $request->admin_notes) : (date('Y-m-d') . ": " . $request->admin_notes);
            }
            $agent->save();

            // Ensure user has principal-agent role and active status
            $user = $agent->user;
            if ($user) {
                $role = Role::firstOrCreate(['slug' => 'principal-agent'], ['name' => 'Principal Agent']);
                $user->roles()->syncWithoutDetaching([$role->id]);
                $user->status = 'active';
                $user->save();
            }

            return back()->with('success', 'Agent successfully approved! Assigned Agent ID: ' . $agent->agent_code);
        });
    }

    public function reject(Request $request, AgentProfile $agent)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:2000',
        ]);

        $agent->application_status = 'rejected';
        $agent->admin_internal_notes = $agent->admin_internal_notes ? ($agent->admin_internal_notes . "\n" . date('Y-m-d') . " [REJECTED]: " . $request->admin_notes) : (date('Y-m-d') . " [REJECTED]: " . $request->admin_notes);
        $agent->save();

        return back()->with('success', 'Agent application marked as Rejected.');
    }

    public function suspend(Request $request, AgentProfile $agent)
    {
        $request->validate([
            'reason' => 'required|string|max:2000',
        ]);

        $agent->application_status = 'suspended';
        $agent->admin_internal_notes = $agent->admin_internal_notes ? ($agent->admin_internal_notes . "\n" . date('Y-m-d') . " [SUSPENDED]: " . $request->reason) : (date('Y-m-d') . " [SUSPENDED]: " . $request->reason);
        $agent->save();

        return back()->with('success', 'Agent account suspended.');
    }

    public function reactivate(AgentProfile $agent)
    {
        $agent->application_status = 'approved';
        $agent->admin_internal_notes = $agent->admin_internal_notes ? ($agent->admin_internal_notes . "\n" . date('Y-m-d') . ": Reactivated by Admin") : (date('Y-m-d') . ": Reactivated by Admin");
        $agent->save();

        return back()->with('success', 'Agent account reactivated to Approved status.');
    }

    public function updateTenderPermission(Request $request, AgentProfile $agent)
    {
        $request->validate([
            'gov_tender_permission' => 'required|in:not_permitted,requested,approved',
            'tender_notes' => 'nullable|string|max:2000',
        ]);

        $agent->gov_tender_permission = $request->gov_tender_permission;
        if ($request->filled('tender_notes')) {
            $agent->gov_tender_notes = $agent->gov_tender_notes ? ($agent->gov_tender_notes . "\n" . date('Y-m-d') . " [MANAGEMENT]: " . $request->tender_notes) : (date('Y-m-d') . " [MANAGEMENT]: " . $request->tender_notes);
        }
        $agent->save();

        return back()->with('success', 'Government Tender permission updated successfully.');
    }

    public function updateNotes(Request $request, AgentProfile $agent)
    {
        $request->validate(['admin_internal_notes' => 'nullable|string']);
        $agent->admin_internal_notes = $request->admin_internal_notes;
        $agent->save();

        return back()->with('success', 'Internal notes saved.');
    }

    public function downloadDoc(AgentProfile $agent, $type)
    {
        $filePath = match ($type) {
            'business_reg' => $agent->business_reg_doc,
            'id_card' => $agent->id_card_doc,
            'agreement' => $agent->agreement_doc,
            default => null,
        };

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'Document not found.');
        }

        return Storage::disk('public')->download($filePath);
    }

    // --- AGENT ORDERS MANAGEMENT (Admin Side) ---
    public function orders(Request $request)
    {
        $query = AgentOrder::with(['user.agentProfile', 'client', 'items']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('source') && $request->source !== 'all') {
            $query->where('order_source', $request->source);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhereHas('agentProfile', fn($ap) => $ap->where('company_name', 'like', "%{$search}%")->orWhere('agent_code', 'like', "%{$search}%"));
                  });
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.agent_management.orders', compact('orders'));
    }

    public function showOrder(AgentOrder $order)
    {
        $order->load(['user.agentProfile', 'client', 'items.product']);
        return view('admin.agent_management.order_show', compact('order'));
    }

    public function updateOrderStatus(Request $request, AgentOrder $order)
    {
        $request->validate([
            'status' => 'required|in:pending,under_review,confirmed,processing,shipped,delivered,cancelled',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $order->status = $request->status;
        if ($request->filled('admin_notes')) {
            $order->admin_notes = $order->admin_notes ? ($order->admin_notes . "\n" . date('Y-m-d H:i') . ": " . $request->admin_notes) : (date('Y-m-d H:i') . ": " . $request->admin_notes);
        }
        $order->save();

        return back()->with('success', 'Order status updated to ' . ucfirst($order->status));
    }

    // --- MARKETING MATERIALS CMS (Admin Side) ---
    public function marketing()
    {
        $materials = AgentMarketingMaterial::orderBy('sort_order')->paginate(15);
        return view('admin.agent_management.marketing', compact('materials'));
    }

    public function storeMarketing(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:catalogue,poster,spec_sheet,training,brochure,photo',
            'description' => 'nullable|string|max:1000',
            'file' => 'required|file|max:51200', // max 50MB
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('marketing_materials', 'public');
        $fileType = strtolower($file->getClientOriginalExtension());
        $fileSize = $file->getSize();

        AgentMarketingMaterial::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Marketing collateral published for Principal Agents.');
    }

    public function destroyMarketing(AgentMarketingMaterial $material)
    {
        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();

        return back()->with('success', 'Marketing material removed.');
    }

    // --- SUPPORT HELPDESK (Admin Side) ---
    public function support(Request $request)
    {
        $query = AgentSupportTicket::with(['user.agentProfile', 'messages']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest('updated_at')->paginate(15)->withQueryString();

        return view('admin.agent_management.support', compact('tickets'));
    }

    public function showSupport(AgentSupportTicket $ticket)
    {
        $ticket->load(['user.agentProfile', 'messages.user']);
        return view('admin.agent_management.support_show', compact('ticket'));
    }

    public function replySupport(Request $request, AgentSupportTicket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:4000',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('support_attachments', 'public');
        }

        AgentSupportMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'is_admin_reply' => true,
            'message' => $validated['message'],
            'attachment_path' => $attachmentPath,
        ]);

        $ticket->status = $validated['status'];
        $ticket->last_reply_at = now();
        $ticket->save();

        return back()->with('success', 'Reply sent to Principal Agent.');
    }
}
