<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Afficher la liste des marques
     */
    public function index()
    {
        $brands = Brand::orderBy('name')->paginate(15);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.brands.form');
    }

    /**
     * Stocker une nouvelle marque
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'price' => 'required|numeric',
            'change' => 'required|numeric',
            'market_cap' => 'required|numeric',
        ]);

        Brand::create($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Marque créée avec succès!');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.form', compact('brand'));
    }

    /**
     * Mettre à jour une marque
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'price' => 'required|numeric',
            'change' => 'required|numeric',
            'market_cap' => 'required|numeric',
        ]);

        $brand->update($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Marque modifiée avec succès!');
    }

    /**
     * Supprimer une marque
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Marque supprimée avec succès!');
    }
}
