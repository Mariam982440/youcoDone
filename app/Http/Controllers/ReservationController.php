<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('restaurateur')) {
            $reservation = Reservation ::whereIn('restaurant_id', [$user->restaurant->id])
            ->with(['restaurant.photos', 'user'])
            ->latest()
            ->paginate(10);

            // Version "Pro" ultra-rapide sans charger les objets restaurants en mémoire
            $reservations = Reservation::whereIn('restaurant_id', function($query) use ($user) {
                $query->select('id')->from('restaurants')->where('user_id', $user->id);
            })->with(['user', 'restaurant'])->latest()->paginate(10);
            
        } else {
            
            $reservations = Reservation::where("user_id", $user->id)
            ->with('restaurant.photos')
            ->latest()
            ->get();
        }
        return view('reservations.index', compact('reservations'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
