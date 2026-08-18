<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $enquiries = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function show(ContactMessage $enquiry)
    {
        if ($enquiry->status === 'new') {
            $enquiry->status = 'read';
            $enquiry->save();
        }
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function updateStatus(Request $request, ContactMessage $enquiry)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,closed',
            'admin_notes' => 'nullable|string',
        ]);

        $enquiry->status = $request->status;
        $enquiry->admin_notes = $request->admin_notes;
        $enquiry->save();

        return redirect()->back()->with('success', 'Enquiry status updated successfully.');
    }

    public function destroy(ContactMessage $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }
}
