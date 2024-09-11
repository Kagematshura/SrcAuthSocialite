<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth to get the current user
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        // Eager load the user relationship to avoid N+1 query problem
        $t_article = Article::with('user')->get();

        $query = Article::query();
        // Paginate the result
        $t_article = $query->paginate(6);

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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'content' => 'required',
    ]);

        $article = new Article;
        $article->title = $request->title;
        $article->content = $request->content;
        $article->user_id = Auth::id();

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('articles', 'public');
        $article->image_path = $imagePath;
    }

    $article->save();

    return redirect()->route('article.index')->with('success', 'Article created successfully!');
}

    public function update(Request $request, $id)
    {
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $article = Article::findOrFail($id);

    $article->title = $request->input('title');
    $article->content = $request->input('content');

    // Handle the image upload
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($article->image_path) {
            Storage::delete('public/' . $article->image_path);
        }

        // Store the new image
        $imagePath = $request->file('image')->store('images', 'public');
        $article->image_path = $imagePath;
    }

    $article->save();

    return redirect()->route('article.index')->with('success', 'Article updated successfully.');
}

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('article.index')->with('success', 'Article deleted successfully.');
    }
    public function show($id)
    {
       $article = Article::with('user')->findOrFail($id);
        $nextArticle = Article::where('id', '>', $id)->orderBy('id')->first();
        $previousArticle = Article::where('id', '<', $id)->orderBy('id', 'desc')->first();

        return view('article.show', compact('article', 'nextArticle', 'previousArticle'));
    }
    public function home()
    {
        $t_article = Article::latest()->paginate(6);
        return view('article.home', compact('t_article'));
    }
    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }
}
