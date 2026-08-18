<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistributorApplication;
use Illuminate\Http\Request;

class DistributorApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = DistributorApplication::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.distributors.index', compact('applications'));
    }

    public function show(DistributorApplication $distributor)
    {
        return view('admin.distributors.show', compact('distributor'));
    }

    public function updateStatus(Request $request, DistributorApplication $distributor)
    {
        $request->validate([
            'status' => 'required|in:new,reviewing,contacted,approved,rejected,closed',
            'admin_notes' => 'nullable|string',
        ]);

        $distributor->status = $request->status;
        $distributor->admin_notes = $request->admin_notes;
        $distributor->save();

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    public function destroy(DistributorApplication $distributor)
    {
        $distributor->delete();
        return redirect()->route('admin.distributors.index')->with('success', 'Application deleted successfully.');
    }

    public function exportCsv()
    {
        $applications = DistributorApplication::all();
        $csvFileName = 'distributor_applications_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($applications) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Company', 'Country', 'Phone', 'Email', 'Order Volume', 'Message', 'Status', 'Date']);

            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->id, $app->name, $app->company, $app->country, $app->phone, $app->email,
                    $app->estimated_order_volume, $app->message, $app->status, $app->created_at
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
