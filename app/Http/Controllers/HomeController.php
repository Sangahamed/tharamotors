<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Vehicle;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function machines()
    {
        return view('machines-engins');
    }

    public function vehicules(Request $request)
    {
        $brands = Vehicle::where('is_available', true)
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        $fuelTypes = Vehicle::where('is_available', true)
            ->distinct()
            ->orderBy('fuel_type')
            ->pluck('fuel_type');

        $vehicles = Vehicle::where('is_available', true)
            ->when($request->brand, function ($query, $brand) {
                return $query->where('brand', $brand);
            })
            ->when($request->fuel_type, function ($query, $fuelType) {
                return $query->where('fuel_type', $fuelType);
            })
            ->when($request->max_price, function ($query, $maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('vehicules-occasion', compact('vehicles', 'brands', 'fuelTypes'));
    }

    public function details($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $similarVehicles = Vehicle::where('brand', $vehicle->brand)
                                ->where('id', '!=', $vehicle->id)
                                ->limit(3)
                                ->get();
        return view('details', compact('vehicle', 'similarVehicles'));
    }

    public function actualite()
    {
        $articles = Article::orderBy('published_at', 'desc')->paginate(12);
        $brands = Brand::orderBy('name')->get();

        return view('actualite', compact('articles', 'brands'));
    }

    public function devis()
    {
        return view('devis');
    }
}
