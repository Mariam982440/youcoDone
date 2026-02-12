<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Découvrir nos Restaurants') }}
            </h2>
            
            <!-- Barre de Recherche Rapide -->
            <form action="{{ route('restaurants.index') }}" method="GET" class="flex gap-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nom du restaurant..." 
                           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm pl-10">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <x-button class="bg-indigo-600">Rechercher</x-button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @role('restaurateur')
                <a href="{{ route('restaurants.create') }}">Publier un restaurant</a>
            @endrole
            
            <!-- FILTRES AVANCÉS -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-100">
                <form action="{{ route('restaurants.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                        <select name="city" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Toutes les villes</option>
                            <option value="Paris" {{ request('city') == 'Paris' ? 'selected' : '' }}>Paris</option>
                            <option value="Lyon" {{ request('city') == 'Lyon' ? 'selected' : '' }}>Lyon</option>
                            <option value="Marseille" {{ request('city') == 'Marseille' ? 'selected' : '' }}>Marseille</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cuisine</label>
                        <select name="cuisine" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Tous les types</option>
                            <option value="Française" {{ request('cuisine') == 'Française' ? 'selected' : '' }}>Française</option>
                            <option value="Italienne" {{ request('cuisine') == 'Italienne' ? 'selected' : '' }}>Italienne</option>
                            <option value="Japonaise" {{ request('cuisine') == 'Japonaise' ? 'selected' : '' }}>Japonaise</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gray-800 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-200 flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filtrer les résultats
                        </button>
                    </div>
                </form>
            </div>

            <!-- GRILLE DES RESTAURANTS -->
            @if($restaurants->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($restaurants as $restaurant)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">
                            
                            <!-- Image avec badge Favoris -->
                            <div class="relative h-48">
                                @if($restaurant->photos->isNotEmpty())
                                    <img src="{{ $restaurant->photos->first()->url }}" class="w-full h-full object-cover" alt="{{ $restaurant->name }}">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Badge Type de Cuisine -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-indigo-600 uppercase tracking-wider shadow-sm">
                                        {{ $restaurant->cuisine_type }}
                                    </span>
                                </div>

                                <!-- Bouton Favoris -->
                                @auth
                                    <form action="{{ route('favorites.toggle', $restaurant) }}" method="POST" class="absolute top-4 right-4">
                                        @csrf
                                        <button type="submit" class="p-2 bg-white/90 backdrop-blur rounded-full shadow-sm transition {{ auth()->user()->favoriteRestaurants->contains($restaurant->id) ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ auth()->user()->favoriteRestaurants->contains($restaurant->id) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endauth
                            </div>

                            <!-- Contenu de la Carte -->
                            <div class="p-6 flex-grow">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $restaurant->name }}</h3>
                                    <div class="flex items-center text-yellow-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="ml-1 text-gray-600 text-sm font-medium">4.8</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center text-gray-500 text-sm mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $restaurant->city }}
                                </div>

                                <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                                    {{ $restaurant->description ?? 'Aucune description disponible pour le moment.' }}
                                </p>

                                <div class="border-t pt-4 flex items-center justify-between mt-auto">
                                    <span class="text-xs font-semibold text-gray-400 uppercase">
                                        {{ $restaurant->menus->count() }} Menus disponibles
                                    </span>
                                    <a href="{{ route('restaurants.show', $restaurant) }}" 
                                       class="text-indigo-600 font-bold hover:text-indigo-800 transition-colors inline-flex items-center group">
                                        Détails
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="mt-12">
                    {{ $restaurants->appends(request()->query())->links() }}
                </div>
            @else
                <!-- ETAT VIDE -->
                <div class="bg-white rounded-2xl p-12 text-center shadow-sm">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Aucun restaurant trouvé</h3>
                    <p class="text-gray-500 mb-6">Essayez de modifier vos critères de recherche ou de changer de ville.</p>
                    <a href="{{ route('restaurants.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Réinitialiser tous les filtres
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>