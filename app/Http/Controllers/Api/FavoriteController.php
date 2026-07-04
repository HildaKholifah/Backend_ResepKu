<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // tambah favorit
    public function store($recipe_id)
    {
        $recipe = Recipe::find($recipe_id);

        if (!$recipe) {
            return response()->json([
                'success' => false,
                'message' => 'Resep tidak ditemukan'
            ], 404);
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('recipe_id', $recipe_id)
            ->first();

        if ($favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Resep sudah difavoritkan'
            ], 400);
        }

        Favorite::create([
            'user_id' => Auth::id(),
            'recipe_id' => $recipe_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil ditambahkan ke favorit'
        ], 201);
    }

    // hapus favorit
    public function destroy($recipe_id)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('recipe_id', $recipe_id)
            ->first();

        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Favorit tidak ditemukan'
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Favorit berhasil dihapus'
        ]);
    }

    // daftar favorit user login
    public function index()
    {
        $favorites = Favorite::with('recipe')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->pluck('recipe');

        return response()->json([
            'success' => true,
            'data' => $favorites
        ]);
    }

    public function check($recipe_id)
    {
        $exists = Favorite::where('user_id', Auth::id())
            ->where('recipe_id', $recipe_id)
            ->exists();

        return response()->json([
            'success' => true,
            'is_favorite' => $exists
        ]);
    }
}