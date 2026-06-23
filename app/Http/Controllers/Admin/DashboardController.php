<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Afficher le dashboard admin
     */
    public function index()
    {
        $stats = [
            'articles' => Article::count(),
            'brands' => Brand::count(),
            'users' => User::count(),
            'vehicles' => Vehicle::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
