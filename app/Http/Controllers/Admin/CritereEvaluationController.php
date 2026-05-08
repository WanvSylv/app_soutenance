<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CritereEvaluation;
use Illuminate\Http\Request;

class CritereEvaluationController extends Controller
{
    public function index()
    {
        $criteres = CritereEvaluation::orderBy('ordre')->get();
        return view('admin.criteres.index', compact('criteres'));
    }

    public function create()
    {
        return view('admin.criteres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle'     => 'required|string|max:150',
            'coefficient' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'ordre'       => 'required|integer|min:1',
            'actif'       => 'boolean',
        ]);

        CritereEvaluation::create(array_merge(
            $request->only(['libelle', 'coefficient', 'description', 'ordre']),
            ['actif' => $request->boolean('actif')]
        ));

        return redirect()->route('admin.criteres.index')->with('success', 'Critère créé avec succès.');
    }

    public function edit(CritereEvaluation $critere)
    {
        return view('admin.criteres.edit', compact('critere'));
    }

    public function update(Request $request, CritereEvaluation $critere)
    {
        $request->validate([
            'libelle'     => 'required|string|max:150',
            'coefficient' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'ordre'       => 'required|integer|min:1',
            'actif'       => 'boolean',
        ]);

        $critere->update(array_merge(
            $request->only(['libelle', 'coefficient', 'description', 'ordre']),
            ['actif' => $request->boolean('actif')]
        ));

        return redirect()->route('admin.criteres.index')->with('success', 'Critère mis à jour avec succès.');
    }

    public function destroy(CritereEvaluation $critere)
    {
        $critere->delete();
        return redirect()->route('admin.criteres.index')->with('success', 'Critère supprimé.');
    }
}
