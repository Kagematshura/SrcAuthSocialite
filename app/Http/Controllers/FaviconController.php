<?php
namespace App\Http\Controllers;

use App\Models\Favicon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaviconController extends Controller
{
    // Show the upload form
    public function showUploadForm()
    {
        $favicons = Favicon::all();
        return view('layout.favicon', compact('favicons'));
    }

    // Handle the file upload
    public function uploadFavicon(Request $request)
    {
        // Validate the request
        $request->validate([
            'favicon' => 'required|image|mimes:png,ico|max:2048',
        ]);

        // Store the uploaded favicon in the 'public' directory
        $faviconPath = $request->file('favicon')->store('favicons', 'public');

        // Save the favicon path to the database
        Favicon::create(['favicon_path' => $faviconPath]);

        return redirect()->back()->with('success', 'Favicon uploaded successfully!');
    }

    public function deleteFavicon($id)
    {
        // Find the favicon by ID
        $favicon = Favicon::findOrFail($id);

        // Delete the favicon file from storage
        $currentPath = public_path('storage/' . $favicon->favicon_path);
        if (file_exists($currentPath)) {
            unlink($currentPath); // Delete the file from storage
        }

        // Delete the favicon record from the database
        $favicon->delete();

        return redirect()->route('favicon.index')->with('success', 'Favicon deleted successfully.');
    }
}
