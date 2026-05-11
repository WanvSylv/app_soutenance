<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnneeAcademique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnneeAcademiqueController extends Controller
{
    public function index()
    {
        $annees = AnneeAcademique::latest()->get();
        return view('admin.annees.index', compact('annees'));
    }

    public function create()
    {
        return view('admin.annees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:20|unique:annees_academiques',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'active' => 'boolean',
        ]);

        DB::transaction(function () use ($request) {
            $data = $request->all();
            $data['active'] = $request->has('active');

            if ($data['active']) {
                AnneeAcademique::where('active', true)->update(['active' => false]);
            }

            AnneeAcademique::create($data);
        });

        return redirect()->route('admin.annees-academiques.index')->with('success', 'Année académique créée avec succès.');
    }

    public function edit(AnneeAcademique $annees_academique)
    {
        $annee = $annees_academique;
        return view('admin.annees.edit', compact('annee'));
    }

    public function update(Request $request, AnneeAcademique $annees_academique)
    {
        $annee = $annees_academique;
        
        $request->validate([
            'libelle' => 'required|string|max:20|unique:annees_academiques,libelle,' . $annee->id,
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'active' => 'boolean',
        ]);

        DB::transaction(function () use ($request, $annee) {
            $data = $request->all();
            $data['active'] = $request->has('active');

            if ($data['active'] && !$annee->active) {
                AnneeAcademique::where('active', true)->update(['active' => false]);
            }

            $annee->update($data);
        });

        return redirect()->route('admin.annees-academiques.index')->with('success', 'Année académique mise à jour avec succès.');
    }

    public function destroy(AnneeAcademique $annees_academique)
    {
        if ($annees_academique->active) {
            return back()->with('error', 'Impossible de supprimer l\'année académique active.');
        }

        $annees_academique->delete();
        return redirect()->route('admin.annees-academiques.index')->with('success', 'Année académique supprimée.');
    }
}
