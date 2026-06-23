<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Vehicle;
use App\Models\Brand;

class home extends Controller
{
    function index()
    {
        return view('home');
    }

    function machines()
    {
        return view('machines-engins');
    }
   

    function vehicules()
    {
        $vehicles = Vehicle::where('is_available', true)->orderBy('created_at', 'desc')->paginate(12);
        return view('vehicules-occasion', compact('vehicles'));
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

        function actualite()
        {
            $articles = Article::orderBy('published_at', 'desc')->paginate(12);
            $brands = Brand::orderBy('name')->get();

            return view('actualite', compact('articles', 'brands'));
        }
        function devis()
        {
            return view('devis');
        }

}
