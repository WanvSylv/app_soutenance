<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = Enseignant::with('user')->latest()->get();
        return view('admin.enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        return view('admin.enseignants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'grade' => 'required|string|max:100',
            'specialite' => 'required|string|max:150',
            'departement' => 'nullable|string|max:150',
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
            'role' => 'enseignant',
            'telephone' => $request->telephone,
            'photo_path' => $photoPath,
            'actif' => true,
        ]);

        $user->enseignant()->create([
            'grade' => $request->grade,
            'specialite' => $request->specialite,
            'departement' => $request->departement,
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WelcomeEnseignantMail($user, $password));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur d'envoi de mail de bienvenue à {$user->email} : " . $e->getMessage());
        }

        return redirect()->route('admin.enseignants.index')->with('success', "Enseignant créé avec succès. L'email contenant les identifiants a été envoyé.");
    }

    public function edit(Enseignant $enseignant)
    {
        $enseignant->load('user');
        return view('admin.enseignants.edit', compact('enseignant'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $enseignant->user_id,
            'grade' => 'required|string|max:100',
            'specialite' => 'required|string|max:150',
            'departement' => 'nullable|string|max:150',
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
            if ($enseignant->user->photo_path) {
                @unlink(public_path($enseignant->user->photo_path));
            }
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profiles'), $filename);
            $userData['photo_path'] = 'uploads/profiles/' . $filename;
        }

        $enseignant->user->update($userData);

        $enseignant->update([
            'grade' => $request->grade,
            'specialite' => $request->specialite,
            'departement' => $request->departement,
        ]);

        return redirect()->route('admin.enseignants.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroy(Enseignant $enseignant)
    {
        $enseignant->user->delete(); // Cascades to enseignant profile
        return redirect()->route('admin.enseignants.index')->with('success', 'Enseignant supprimé avec succès.');
    }
}
