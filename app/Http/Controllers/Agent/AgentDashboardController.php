<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentClient;
use App\Models\AgentEnquiry;
use App\Models\AgentOrder;
use App\Models\AgentSupportTicket;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->agentProfile;

        // Metrics scoped strictly to authenticated agent
        $clientsCount = AgentClient::where('user_id', $user->id)->count();
        $enquiriesCount = AgentEnquiry::where('user_id', $user->id)->count();
        $pendingOrdersCount = AgentOrder::where('user_id', $user->id)->whereIn('status', ['pending', 'under_review'])->count();
        $totalOrdersCount = AgentOrder::where('user_id', $user->id)->count();
        $totalOrderValue = AgentOrder::where('user_id', $user->id)->where('status', '!=', 'cancelled')->sum('total_amount');

        // Recent Orders
        $recentOrders = AgentOrder::with('client')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Recent Enquiries
        $recentEnquiries = AgentEnquiry::with('client')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Featured Wholesale Products
        $featuredProducts = Product::where('status', 'published')
            ->whereNotNull('wholesale_price')
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        // Active Support Tickets
        $openTicketsCount = AgentSupportTicket::where('user_id', $user->id)
            ->whereIn('status', ['open', 'in_progress'])
            ->count();

        return view('agent.dashboard', compact(
            'user',
            'profile',
            'clientsCount',
            'enquiriesCount',
            'pendingOrdersCount',
            'totalOrdersCount',
            'totalOrderValue',
            'recentOrders',
            'recentEnquiries',
            'featuredProducts',
            'openTicketsCount'
        ));
    }
}
