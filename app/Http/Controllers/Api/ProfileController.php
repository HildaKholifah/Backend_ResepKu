<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        // VALIDASI
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email,' . $user->id,

            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // UPDATE NAME & EMAIL
        $user->name = $request->name;
        $user->email = $request->email;

        // UPDATE PHOTO
        if ($request->hasFile('photo')) {

            $photo = $request->file('photo');

            $filename = time() . '.' . $photo->getClientOriginalExtension();

            $photo->storeAs(
                'profile',
                $filename,
                'public'
            );

            $user->photo =
                asset('storage/profile/' . $filename);
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user,
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // PASSWORD LAMA HARUS BENAR
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password lama tidak sesuai.',
            ], 400);
        }

        // PASSWORD BARU TIDAK BOLEH SAMA DENGAN PASSWORD LAMA
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password baru tidak boleh sama dengan password lama.',
            ], 400);
        }

        // SIMPAN PASSWORD BARU
        $user->password = Hash::make($request->new_password);
        $user->save();

        // OPTIONAL
        // Logout seluruh device
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diubah.',
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $photo = $request->file('photo');

        $filename = time() . '.' . $photo->getClientOriginalExtension();

        $photo->storeAs('profile', $filename, 'public');

        $user->photo = asset('storage/profile/' . $filename);

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Foto profil berhasil diperbarui',
            'user' => $user,
        ]);
    }
}