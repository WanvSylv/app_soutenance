<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'string', 'in:admin,enseignant,etudiant'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos/profiles', 'public');
        }

        $password = \Illuminate\Support\Str::random(10);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
            'telephone' => $request->telephone,
            'photo_path' => $photoPath,
            'actif' => true,
        ]);

        // Créer les profils si nécessaire
        if ($user->role === 'etudiant') {
            $user->etudiant()->create([
                'matricule' => 'TEMP_' . $user->id . '_' . time(),
                'filiere' => 'À définir',
                'niveau' => 'À définir',
                'annee_inscription' => date('Y'),
            ]);
        } elseif ($user->role === 'enseignant') {
            $user->enseignant()->create([
                'grade' => 'À définir',
                'specialite' => 'À définir',
            ]);
        }

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WelcomeUserMail($user, $password));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur d'envoi de mail de bienvenue à {$user->email} : " . $e->getMessage());
        }

        return redirect()->route('admin.users.index')->with('success', "Utilisateur créé avec succès. L'email contenant le mot de passe a été envoyé.");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'string', 'in:admin,enseignant,etudiant'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'actif' => ['boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = $request->only(['nom', 'prenom', 'email', 'role', 'telephone', 'actif']);

        if ($request->hasFile('photo')) {
            if ($user->photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('photos/profiles', 'public');
        }

        $user->update($data);

        // Vérifier si les profils existent pour le nouveau rôle
        if ($user->role === 'etudiant' && !$user->etudiant) {
            $user->etudiant()->create([
                'matricule' => 'TEMP_' . $user->id . '_' . time(),
                'filiere' => 'À définir',
                'niveau' => 'À définir',
                'annee_inscription' => date('Y'),
            ]);
        } elseif ($user->role === 'enseignant' && !$user->enseignant) {
            $user->enseignant()->create([
                'grade' => 'À définir',
                'specialite' => 'À définir',
            ]);
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
