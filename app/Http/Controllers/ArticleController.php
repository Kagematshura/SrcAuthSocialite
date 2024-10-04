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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,json|max:2048',
        'content' => 'required',
        'category' => 'required|string',
        'sts' => 'required',
    ]);

    $article = new Article;
    $article->title = $request->title;
    $article->user_id = Auth::id();
    $article->content = $request->content;
    $article->category = $request->category;
    $article->sts = $request->sts;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $article->image_path = $imagePath;
    }

    $article->save();

    return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category' => 'required|string',
        'sts' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
    ]);

    $article->update($validated);

    if ($request->hasFile('image')) {
        $currentImage = '/storage/'.$article->image_path;

        if ($currentImage && file_exists(public_path($currentImage))) {
            unlink(public_path($currentImage));
        } else {
            dd(public_path($currentImage));
        }

        $newImage = $request->file('image');
        $imagePath = $newImage->store('images', 'public');
        $article->image_path = $imagePath;
    }

    $article->title = $request->input('title');
    $article->content = $request->input('content');
    $article->category = $request->input('category');

    $article->save();

    return response()->json(['success' => true]);
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
    // public function edit(Article $article)
    // {
    //     return view('article.edit', compact('article'));
    // }
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }
}
