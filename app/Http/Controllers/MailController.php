<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mail;

class MailController extends Controller
{
    public function create()
    {
        return view('mails.create');
    }

    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'message' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|max:255',
        ]);

        // Store the mail
        Mail::create($request->all());

        return redirect()->route('mails.create')->with('success', 'Mail saved successfully!');
    }

    public function index()
    {
        $mails = Mail::all();
        return view('mails.index', compact('mails'));
    }

    public function show($id)
{
    $mail = Mail::find($id);

    return view('mails.show', compact('mail'));
}

public function destroy($id)
    {
        $mail = Mail::findOrFail($id);
        $mail->delete();

        return redirect()->route('mails.index')->with('success', 'Mail deleted successfully.');
    }

}
