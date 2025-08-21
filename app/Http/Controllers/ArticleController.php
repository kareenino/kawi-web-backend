<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // get all articles
    public function index()
    {
        $articles = Article::where('is_published', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($articles, 200);
    }

    //get Article
    public function getArticle($id){
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    //create article
    public function store(Request $request){
        $validated = $request->validate([
            'category_id'=> 'required|integer',
            'title'=> 'required|string',
            'slug'=> 'required|string',
            'content'=> 'required|string',
            'is_published'
        ]);

        $article = Article::create($validated);

        return response()->json(
            [
                'message' => 'Article created successfully',
                'data' => $article
            ], 500);
    }

    //update article
    public function updateArticle($id, Request $request){

        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'category_id'=> 'integer',
            'title'=> 'required|string',
            'slug'=> 'required|string',
            'content'=> 'required|string',
            'is_published'=> 'string',
        ]);

        $article->update($validated);

        return response()->json(
            [
                'message' => 'Article updated successfully',
                'data' => $article
            ], 500);
    }

    //delete article
    public function deleteArticle($id){
        {
            $article = Article::findOrFail($id);
            $article->delete();
        }

        return response()->json(
            [
                'message' => 'Article deleted successfully'
            ], 500);
    }
}