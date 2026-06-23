<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Afficher la liste des véhicules
     */
    public function index()
    {
        $vehicles = Vehicle::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.vehicles.form');
    }

    /**
     * Stocker un nouveau véhicule
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|integer|min:0',
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
            'is_available' => 'boolean',
        ]);

        // Gestion de l'upload des images
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('vehicles', $imageName, 'public');
                    $uploadedImages[] = $imageName;
                }
            }
        }

        $validated['images'] = $uploadedImages;

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')->with('success', 'Véhicule créé avec succès!');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.form', compact('vehicle'));
    }

    /**
     * Mettre à jour un véhicule
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|integer|min:0',
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            'is_available' => 'boolean',
        ]);

        // Gestion de l'upload des nouvelles images
        $uploadedImages = $vehicle->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('vehicles', $imageName, 'public');
                    $uploadedImages[] = $imageName;
                }
            }
        }

        $validated['images'] = $uploadedImages;

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')->with('success', 'Véhicule modifié avec succès!');
    }

    /**
     * Supprimer un véhicule
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Véhicule supprimé avec succès!');
    }

    /**
     * Changer le statut de disponibilité
     */
    public function toggleAvailability(Vehicle $vehicle)
    {
        $vehicle->update(['is_available' => !$vehicle->is_available]);
        
        $status = $vehicle->is_available ? 'disponible' : 'indisponible';
        return redirect()->back()->with('success', "Véhicule marqué comme {$status}!");
    }
}
