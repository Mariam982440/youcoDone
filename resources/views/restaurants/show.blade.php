<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Lien de retour -->
            <div class="mb-6">
                <a href="{{ route('restaurants.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Retour à la liste
                </a>
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
                                No images available
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- COLONNE GAUCHE : MENUS ET PLATS -->
                <div class="lg:col-span-2 space-y-8">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        La Carte du Restaurant
                    </h2>

                    @forelse($restaurant->menus as $menu)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="bg-indigo-50 p-4 border-b border-indigo-100">
                                <h3 class="text-lg font-bold text-indigo-900">{{ $menu->title }}</h3>
                                <p class="text-indigo-700 text-sm">{{ $menu->description }}</p>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-6">
                                    @foreach($menu->dishes as $dish)
                                        <li class="flex justify-between items-start">
                                            <div class="flex gap-4">
                                                @if($dish->photo)
                                                    <img src="{{ $dish->photo }}" class="w-16 h-16 rounded-lg object-cover">
                                                @endif
                                                <div>
                                                    <span class="text-xs font-bold text-gray-400 uppercase">{{ $dish->category->name }}</span>
                                                    <h4 class="font-bold text-gray-900">{{ $dish->name }}</h4>
                                                    @if(!$dish->is_available)
                                                        <span class="text-red-500 text-xs font-medium">Non disponible aujourd'hui</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="font-bold text-indigo-600">{{ number_format($dish->price, 2) }} €</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="bg-gray-50 rounded-xl p-8 text-center text-gray-500 border border-dashed border-gray-300">
                            Aucun menu n'a encore été publié pour ce restaurant.
                        </div>
                    @endforelse
                </div>

                <!-- COLONNE DROITE : HORAIRES ET INFOS -->
                <div class="space-y-8">
                    <!-- Horaires -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Horaires d'ouverture
                        </h3>
                        <ul class="space-y-3">
                            @if($restaurant->opening_hours)
                                @foreach($restaurant->opening_hours as $jour => $horaire)
                                    <li class="flex justify-between text-sm {{ $jour == now()->translatedFormat('l') ? 'font-bold text-indigo-600' : 'text-gray-600' }}">
                                        <span>{{ $jour }}</span>
                                        <span>{{ $horaire ?? 'Fermé' }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-gray-400 italic">Non renseignés</li>
                            @endif
                        </ul>
                    </div>

                    <!-- Action Favoris -->
                    <div class="bg-indigo-600 rounded-2xl shadow-lg p-6 text-white text-center">
                        <h3 class="font-bold mb-4">Ce restaurant vous plaît ?</h3>
                        <button class="w-full bg-white text-indigo-600 font-bold py-3 rounded-xl hover:bg-indigo-50 transition flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Ajouter aux favoris
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>