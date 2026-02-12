<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Restaurant::with(['photos', 'menus']);

        // Si l'utilisateur est connecté, on charge ses favoris pour éviter le N+1
        if (auth()->check()) {
            $query->with(['favoritedBy' => function($q) {
                $q->where('user_id', auth()->id());
            }]);
        }
        if ($request->filled('city')) {
            $query->where('city', 'LIKE', '%' . $request->city . '%');
        }

        if ($request->filled('cuisine')) {
            $query->where('cuisine_type', $request->cuisine);
        }
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // récupération avec pagination
        $restaurants = $query->latest()->paginate(12);

        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation (Critère n°2)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'cuisine_type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'opening_hours' => 'required|array', // On reçoit un tableau du formulaire
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validation des images
        ]);
    

        // 2. Création du restaurant (Mass Assignment)
        $restaurant = Restaurant::create([
            'owner_id' => Auth::id(),
            'name' => $validated['name'],
            'city' => $validated['city'],
            'cuisine_type' => $validated['cuisine_type'],
            'capacity' => $validated['capacity'],
            'description' => $validated['description'],
            'opening_hours' => $validated['opening_hours'], // Automatiquement converti en JSON par le Model
        ]);

        // 3. Gestion des Photos (si présentes)
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('restaurants', 'public'); // Stockage dans storage/app/public/restaurants
                
                // Création dans la table photos (Relation One-To-Many)
                $restaurant->photos()->create([
                    'url' => '/storage/' . $path
                ]);
            }
        }

        return redirect()->route('restaurants.index')->with('success', 'Votre restaurant a été publié avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['photos', 'menus.dishes.category']);

        return view('restaurants.show', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        Gate::authorize('update', $restaurant);
        return view('restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        Gate::authorize('update', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'cuisine_type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'opening_hours' => 'required|array',
        ]);

        // mise à jour des données textuelles
        $restaurant->update($validated);

        // gestion des nouvelles photos (optionnel)
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('restaurants', 'public');
                $restaurant->photos()->create(['url' => '/storage/' . $path]);
            }
        }

        return redirect()->route('restaurants.show', $restaurant)
                        ->with('success', 'Le restaurant a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        Gate::authorize('delete', $restaurant);
        $restaurant->delete();

        return redirect()->route('restaurants.index')
                        ->with('success', 'Le restaurant a été supprimé avec succès.');
    }

   


}