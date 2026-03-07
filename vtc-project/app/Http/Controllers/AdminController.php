<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Chauffeur;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Identifiants incorrects.'], 401);
        }

        $token = $admin->createToken('admin_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'role' => 'admin']);
    }

    public function listChauffeurs()
    {
        $chauffeurs = Chauffeur::select('id', 'name', 'email', 'statut')->get();
        return response()->json($chauffeurs);
    }

    public function approuver($id)
    {
        $chauffeur = Chauffeur::findOrFail($id);
        $chauffeur->update(['statut' => 'approved']);
        return response()->json(['message' => 'Chauffeur approuvé.', 'chauffeur' => $chauffeur]);
    }

    public function refuser($id)
    {
        $chauffeur = Chauffeur::findOrFail($id);
        $chauffeur->update(['statut' => 'rejected']);
        return response()->json(['message' => 'Chauffeur refusé.', 'chauffeur' => $chauffeur]);
    }
}
