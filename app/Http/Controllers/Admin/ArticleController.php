<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Afficher la liste des articles
     */
    public function index()
    {
        $articles = Article::orderBy('published_at', 'desc')->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.articles.form');
    }

    /**
     * Stocker un nouvel article
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'image_url' => 'nullable|url',
            'source_url' => 'required|url',
            'published_at' => 'required|date',
        ]);

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Article créé avec succès!');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Article $article)
    {
        return view('admin.articles.form', compact('article'));
    }

    /**
     * Mettre à jour un article
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'image_url' => 'nullable|url',
            'source_url' => 'required|url',
            'published_at' => 'required|date',
        ]);

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Article modifié avec succès!');
    }

    /**
     * Supprimer un article
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article supprimé avec succès!');
    }
}
