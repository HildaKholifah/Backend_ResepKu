<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    // ambil komentar berdasarkan resep
    public function index($recipe_id)
    {
        $comments = Comment::with('user')
            ->where('recipe_id', $recipe_id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $comments
        ]);
    }

    // tambah komentar
    public function store(Request $request, $recipe_id)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'recipe_id' => $recipe_id,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Komentar berhasil ditambahkan',
            'data' => $comment
        ]);
    }
}