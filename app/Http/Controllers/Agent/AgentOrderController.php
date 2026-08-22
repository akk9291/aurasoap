<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentClient;
use App\Models\AgentOrder;
use App\Models\AgentOrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = AgentOrder::with(['client', 'items'])->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('client', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('company_name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('agent.orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $clients = AgentClient::where('user_id', Auth::id())->where('status', 'active')->orderBy('name')->get();
        $products = Product::where('status', 'published')->whereNotNull('wholesale_price')->orderBy('sort_order')->get();
        $selectedClientId = $request->query('client_id');

        return view('agent.orders.create', compact('clients', 'products', 'selectedClientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|exists:agent_clients,id',
            'required_delivery_date' => 'nullable|date|after_or_equal:today',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:2000',
            'financial_notes' => 'nullable|string|max:2000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'items.min' => 'Please add at least one product to your order.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
        ]);

        // Security check for client ownership
        if (!empty($validated['client_id'])) {
            $client = AgentClient::where('id', $validated['client_id'])->where('user_id', Auth::id())->first();
            if (!$client) {
                abort(403, 'Invalid client selected.');
            }
        }

        return DB::transaction(function () use ($validated) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($validated['items'] as $itemInput) {
                $product = Product::findOrFail($itemInput['product_id']);
                $qty = (int)$itemInput['quantity'];
                $unitPrice = $product->wholesale_price ?? 0;
                $lineSubtotal = $unitPrice * $qty;
                $subtotal += $lineSubtotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $qty,
                    'subtotal' => $lineSubtotal,
                ];
            }

            $order = AgentOrder::create([
                'order_number' => AgentOrder::generateOrderNumber(),
                'user_id' => Auth::id(),
                'client_id' => $validated['client_id'] ?? null,
                'order_source' => 'portal',
                'status' => 'pending',
                'required_delivery_date' => $validated['required_delivery_date'] ?? null,
                'shipping_address' => $validated['shipping_address'],
                'notes' => $validated['notes'] ?? null,
                'financial_notes' => $validated['financial_notes'] ?? null,
                'subtotal' => $subtotal,
                'tax_amount' => 0.00,
                'shipping_amount' => 0.00,
                'total_amount' => $subtotal,
                'currency' => 'USD',
            ]);

            foreach ($itemsData as $item) {
                $item['order_id'] = $order->id;
                AgentOrderItem::create($item);
            }

            return redirect()->route('agent.orders.show', $order)->with('success', 'Order submitted successfully! Order Number: ' . $order->order_number);
        });
    }

    public function show(AgentOrder $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized. You can only view your own orders.');
        }

        $order->load(['client', 'items.product', 'user.agentProfile']);

        return view('agent.orders.show', compact('order'));
    }

    public function invoice(AgentOrder $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        $order->load(['client', 'items.product', 'user.agentProfile']);

        return view('agent.orders.invoice', compact('order'));
    }

    public function cancel(AgentOrder $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        if (!in_array($order->status, ['pending', 'under_review'])) {
            return back()->with('error', 'Only pending or under-review orders can be cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Order ' . $order->order_number . ' has been cancelled.');
    }
}
