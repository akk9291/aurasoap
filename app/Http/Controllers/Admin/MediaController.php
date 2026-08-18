<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query();

        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%')
                  ->orWhere('alt_text', 'like', '%' . $request->search . '%');
        }

        $mediaFiles = $query->orderBy('created_at', 'desc')->paginate(18);

        return view('admin.media.index', compact('mediaFiles'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');

            $media = Media::create([
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'file_path' => 'storage/' . $path,
                'disk' => 'public',
                'file_size' => $file->getSize(),
                'alt_text' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            ]);

            $uploaded[] = $media;
        }

        return redirect()->back()->with('success', count($uploaded) . ' media file(s) uploaded successfully.');
    }

    public function destroy(Media $media)
    {
        $relativePath = str_replace('storage/', '', $media->file_path);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        $media->delete();

        return redirect()->back()->with('success', 'Media file deleted successfully.');
    }
}
