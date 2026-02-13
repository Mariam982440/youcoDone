<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\RestaurantClosure;
use Illuminate\Support\Facades\Gate;

class RestaurantClosureController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        Gate::authorize('update', $restaurant); // seul le proprio peut gérer

        $closures = $restaurant->closures()->orderBy('closed_date', 'asc')->get();
        
        return view('closures.index', compact('restaurant', 'closures'));
    }
    public function store(Request $request, Restaurant $restaurant)
    {
        $validated= $request->validate([
            'closed_date' => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string|max:255'
        ]);
        $restaurant->closures()->create($validated);
        return back()->with('success', 'La date de fermeture a été ajoutée.');
    }
    public function destroy(RestaurantClosure $closure)
    {
        $restaurant= $closure->restaurant;
        $closure->delete();
        return back()->with('success', 'Fermeture supprimée avec succès.');
    }

}
