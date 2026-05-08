<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salle;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    public function index()
    {
        $salles = Salle::latest()->get();
        return view('admin.salles.index', compact('salles'));
    }

    public function create()
    {
        return view('admin.salles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:salles',
            'capacite' => 'nullable|integer|min:1',
            'localisation' => 'nullable|string|max:200',
            'equipements' => 'nullable|string',
        ]);

        Salle::create($request->all());

        return redirect()->route('admin.salles.index')->with('success', 'Salle créée avec succès.');
    }

    public function edit(Salle $salle)
    {
        return view('admin.salles.edit', compact('salle'));
    }

    public function update(Request $request, Salle $salle)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:salles,code,' . $salle->id,
            'capacite' => 'nullable|integer|min:1',
            'localisation' => 'nullable|string|max:200',
            'equipements' => 'nullable|string',
        ]);

        $salle->update($request->all());

        return redirect()->route('admin.salles.index')->with('success', 'Salle mise à jour avec succès.');
    }

    public function destroy(Salle $salle)
    {
        $salle->delete();
        return redirect()->route('admin.salles.index')->with('success', 'Salle supprimée avec succès.');
    }
}
