<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth to get the current user

class ArticleController extends Controller
{
    public function index()
    {
        // Eager load the user relationship to avoid N+1 query problem
        $t_article = Article::with('user')->get();
        return view('article.index', compact('t_article'));
    }

    public function create()
    {
        return view('article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Create a new article with the current user's ID
        Article::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(), // Set the user_id to the currently authenticated user's ID
        ]);

        return redirect()->route('article.index')->with('success', 'Article created successfully.');
    }
    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $article->update($request->all());

        return redirect()->route('article.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('article.index')->with('success', 'Article deleted successfully.');
    }
    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }
}
