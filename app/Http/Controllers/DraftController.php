<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Draft;
use Illuminate\Support\Facades\Auth;

class DraftController extends Controller
{
    public function create()
    {
        return view('drafts.create');
    }

    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'type' => 'required|string',
        ]);

        // Store the draft
        Draft::create($request->all());

        return redirect()->route('drafts.create')->with('success', 'Draft saved successfully!');
    }

    public function index()
    {
        $drafts = Draft::all();
        return view('drafts.index', compact('drafts'));
    }

    public function show($id)
{
    $draft = Draft::find($id);

    return view('drafts.show', compact('draft'));
}

    public function approve($id)
    {
        $draft = Draft::find($id);

        // Move draft to articles table
        Article::create([
            'title' => $draft->title,
            'content' => $draft->content,
            'user_id' => Auth::id(),
            'sts' => $draft->type,
        ]);

        // Delete the draft
        $draft->delete();

        return redirect()->route('drafts.index')->with('success', 'Article approved and published.');
    }

    public function setPending($id)
    {
        $draft = Draft::find($id);

        // Update the status to pending
        $draft->status = 'pending';
        $draft->save();

        return redirect()->route('drafts.index')->with('success', 'Draft status updated to pending.');
    }

    public function notApproved($id)
    {
        $draft = Draft::find($id);

        // Update the status to not approved
        $draft->status = 'not approved';
        $draft->save();

        return redirect()->route('drafts.index')->with('success', 'Draft marked as not approved.');
    }
}
