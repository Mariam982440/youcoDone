<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Lien de retour -->
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('restaurants.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Retour à la liste
                </a>

                <!-- BOUTONS D'ACTION (MODIFIER / SUPPRIMER) -->
                @auth
                    @can('update', $restaurant)
                        <div class="flex items-center gap-3">
                            <!-- Bouton Modifier -->
                            <a href="{{ route('restaurants.edit', $restaurant) }}" class="inline-flex items-center bg-blue-600 px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Modifier
                            </a>

                            <!-- Bouton Supprimer -->
                            <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    @endcan
                @endauth
            </div>

            <!-- HEADER & GALERIE -->
            <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100 mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Galerie d'images -->
                    <div class="bg-gray-200 h-96 lg:h-full relative">
                        @if($restaurant->photos->isNotEmpty())
                            <img src="{{ $restaurant->photos->first()->url }}" class="w-full h-full object-cover" alt="{{ $restaurant->name }}">
                            @if($restaurant->photos->count() > 1)
                                <div class="absolute bottom-4 right-4 bg-black/50 text-white px-3 py-1 rounded-full text-sm">
                                    + {{ $restaurant->photos->count() - 1 }} photos
                                </div>
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Infos Principales -->
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                {{ $restaurant->cuisine_type }}
                            </span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ $restaurant->city }}
                            </span>
                        </div>
                        
                        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $restaurant->name }}</h1>
                        <p class="text-gray-600 leading-relaxed mb-6 italic">
                            "{{ $restaurant->description }}"
                        </p>
                        
                        <div class="flex items-center gap-6 border-t pt-6">
                            <div>
                                <span class="block text-2xl font-bold text-gray-900">{{ $restaurant->capacity }}</span>
                                <span class="text-gray-500 text-sm">Couverts</span>
                            </div>
                            <div class="h-10 w-px bg-gray-200"></div>
                            <div>
                                <span class="block text-2xl font-bold text-yellow-500">4.8/5</span>
                                <span class="text-gray-500 text-sm">Note avis</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            @auth
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
        <h3 class="font-bold text-gray-900 mb-4">Vous aimez cet endroit ?</h3>
        <form action="{{ route('favorites.toggle', $restaurant) }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-bold transition {{ auth()->user()->favoriteRestaurants->contains($restaurant->id) ? 'bg-red-50 text-red-600 border-2 border-red-200' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="{{ auth()->user()->favoriteRestaurants->contains($restaurant->id) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                {{ auth()->user()->favoriteRestaurants->contains($restaurant->id) ? 'Dans vos favoris' : 'Ajouter aux favoris' }}
            </button>
        </form>
    </div>
@endauth

            <!-- ... (Le reste de votre code pour les menus et horaires reste inchangé) ... -->

        </div>
    </div>
</x-app-layout>