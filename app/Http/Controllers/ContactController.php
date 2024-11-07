<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('contact.wa', compact('contacts'));
    }
    public function data()
    {
        $pNumber = DB::table('contacts')->where('id', 1)->first();
        return response()->json($pNumber);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'whatsappnum' => 'required|string|max:255',
            'instagram' => 'required|string|max:255',
            'facebook' => 'required|string|max:255',
            'twitter' => 'required|string|max:255',
            'tiktok' => 'required|string|max:255',
        ]);

        Contact::create([
            'id' => $request->id,
            'whatsappnum' => $request->whatsappnum,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'tiktok' => $request->tiktok,
        ]);

        return response()->json(['success' => true]);    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'whatsappnum' => 'required|string|max:255',
            'instagram' => 'required|string|max:255',
            'facebook' => 'required|string|max:255',
            'twitter' => 'required|string|max:255',
            'tiktok' => 'required|string|max:255',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update([
            'whatsappnum' => $request->whatsappnum,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'tiktok' => $request->tiktok,
        ]);

        return response()->json(['success' => true, 'contact' => $contact]);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
