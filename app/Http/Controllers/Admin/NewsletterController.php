<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->back()->with('success', 'Subscriber deleted successfully.');
    }

    public function exportCsv()
    {
        $subscribers = NewsletterSubscriber::all();
        $csvFileName = 'newsletter_subscribers_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Email', 'Name', 'Source', 'Status', 'Date']);

            foreach ($subscribers as $sub) {
                fputcsv($file, [$sub->id, $sub->email, $sub->name, $sub->source, $sub->status, $sub->created_at]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
