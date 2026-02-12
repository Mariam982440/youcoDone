<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
            </svg>
            {{ __('Mes Restaurants Favoris') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notification de succès (ex: quand on retire un favori) -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($favorites->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($favorites as $restaurant)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col h-full">
                            
                            <!-- Image du Restaurant -->
                            <div class="relative h-48">
                                @if($restaurant->photos->isNotEmpty())
                                    <img src="{{ $restaurant->photos->first()->url }}" class="w-full h-full object-cover" alt="{{ $restaurant->name }}">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Bouton pour retirer des favoris (Coeur plein) -->
                                <form action="{{ route('favorites.toggle', $restaurant) }}" method="POST" class="absolute top-4 right-4">
                                    @csrf
                                    <button type="submit" class="p-2 bg-white/90 backdrop-blur rounded-full text-red-500 shadow-sm hover:scale-110 transition duration-200" title="Retirer des favoris">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Infos du Restaurant -->
                            <div class="p-6 flex-grow flex flex-col">
                                <div class="mb-2">
                                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">{{ $restaurant->cuisine_type }}</span>
                                    <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $restaurant->name }}</h3>
                                </div>
                                
                                <p class="text-gray-500 text-sm mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    {{ $restaurant->city }}
                                </p>

                                <div class="mt-auto border-t pt-4">
                                    <a href="{{ route('restaurants.show', $restaurant) }}" class="flex justify-center items-center w-full py-2 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition duration-200">
                                        {{ __('Voir les détails') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $favorites->links() }}
                </div>

            @else
                <!-- ETAT VIDE : Si l'utilisateur n'a aucun favori -->
                <div class="bg-white rounded-3xl p-16 text-center shadow-sm border border-dashed border-gray-300">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-red-50 rounded-full mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Votre liste est vide</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-8 text-lg">
                        Vous n'avez pas encore de restaurants favoris. Explorez notre sélection pour trouver vos prochains lieux préférés !
                    </p>
                    <a href="{{ route('restaurants.index') }}" class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        {{ __('Découvrir les restaurants') }}
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>