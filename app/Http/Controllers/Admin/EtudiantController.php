<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use Illuminate\Support\Str;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::with('user')->latest()->paginate(15);
        return view('admin.etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('admin.etudiants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'matricule' => 'required|string|unique:etudiants',
            'filiere' => 'required|string|max:150',
            'niveau' => 'required|string|max:50',
            'telephone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profiles'), $filename);
            $photoPath = 'uploads/profiles/' . $filename;
        }

        $password = Str::random(10);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'etudiant',
            'telephone' => $request->telephone,
            'photo_path' => $photoPath,
            'actif' => true,
        ]);

        $user->etudiant()->create([
            'matricule' => $request->matricule,
            'filiere' => $request->filiere,
            'niveau' => $request->niveau,
            'annee_inscription' => date('Y'),
            'quitus_valide' => false,
        ]);

        try {
            Mail::to($user->email)->send(new WelcomeUserMail($user, $password));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur d'envoi de mail de bienvenue à {$user->email} : " . $e->getMessage());
        }

        return redirect()->route('admin.etudiants.index')->with('success', "Étudiant créé avec succès. Mot de passe provisoire : $password");
    }

    public function edit(Etudiant $etudiant)
    {
        $etudiant->load('user');
        return view('admin.etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $etudiant->user_id,
            'matricule' => 'required|string|unique:etudiants,matricule,' . $etudiant->id,
            'filiere' => 'required|string|max:150',
            'niveau' => 'required|string|max:50',
            'telephone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userData = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ];

        if ($request->hasFile('photo')) {
            if ($etudiant->user->photo_path) {
                @unlink(public_path($etudiant->user->photo_path));
            }
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profiles'), $filename);
            $userData['photo_path'] = 'uploads/profiles/' . $filename;
        }

        $etudiant->user->update($userData);

        $etudiant->update([
            'matricule' => $request->matricule,
            'filiere' => $request->filiere,
            'niveau' => $request->niveau,
        ]);

        return redirect()->route('admin.etudiants.index')->with('success', 'Profil étudiant mis à jour avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->user->delete(); // Cascades
        return redirect()->route('admin.etudiants.index')->with('success', 'Étudiant supprimé avec succès.');
    }
}
