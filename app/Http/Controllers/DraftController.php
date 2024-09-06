<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Draft;

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

    public function approve($id)
    {
        $draft = Draft::find($id);

        // Move draft to articles table
        Article::create([
            'title' => $draft->title,
            'content' => $draft->content,
            'user_id' => $draft->user_id,
        ]);

        // Delete the draft
        $draft->delete();

        return redirect()->route('drafts.index')->with('success', 'Article approved and published.');
    }
}
