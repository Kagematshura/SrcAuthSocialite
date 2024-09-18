<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $t_post = Article::with('user')->get();

        // Paginate the result
        $t_post = Article::with('user')->paginate(6);

        return view('article.index', compact('t_post'));
    }

    public function create(Request $request)
    {
        $sts = $request->input('sts', 'article');

        return view('article.create', compact('sts'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'content' => 'required',
        'category' => 'required|string',
        'sts' => 'required',
    ]);

    // $imagePath = $request->hasFile('image') ? $request->file('image')->store('articles', 'public') : null;

    // Article::create([
    //     'title' => $request->title,
    //     'content' => $request->content,
    //     'user_id' => Auth::id(),
    //     'image_path' => $imagePath,
    // ]);

    $article = new Article;
    $article->title = $request->title;
    $article->user_id = Auth::id();
    $article->content = $request->content;
    $article->category = $request->category;
    $article->sts = $request->sts;

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
        'category' => 'required|string',
        'sts' => 'required',
    ]);

    $article = Article::findOrFail($id);
    $article->title = $request->input('title');
    $article->content = $request->input('content');
    $article->category = $request->input('category');

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
    public function home(Request $request)
    {
        $query = Article::query();
        // Apply Status Filter
        if ($request->has('sts')) {
            $query->where('sts', $request->input('sts'));
        }

        $t_post = $query->paginate(6);
        return view('article.home', compact('t_post'));
    }
    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }
}
