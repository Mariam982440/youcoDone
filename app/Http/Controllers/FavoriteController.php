<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function toggle(Restaurant $restaurant)
    {
        /** @var \App\Models\User $user */ 
        $user = Auth::user();
        // toggle() va ajouter si ça n'existe pas, et supprimer si ça existe déj
        $status = $user->favoriteRestaurants()->toggle($restaurant->id);

        if (count($status['attached']) > 0) {
            $message = 'Restaurant ajouté aux favoris';
        } else {
            $message = 'Restaurant retiré des favoris';
        }
        return back()->with('success', $message);
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites  = auth()->user()->favoriteRestaurants()->with('photos')->paginate(10);
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
