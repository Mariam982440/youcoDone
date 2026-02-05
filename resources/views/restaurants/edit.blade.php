<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier : ') }} {{ $restaurant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <!-- Formulaire avec méthode PUT pour l'update -->
                <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <x-label for="name" value="Nom du restaurant" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $restaurant->name) }}" required />
                        </div>

                        <!-- Ville -->
                        <div>
                            <x-label for="city" value="Ville" />
                            <x-input id="city" class="block mt-1 w-full" type="text" name="city" value="{{ old('city', $restaurant->city) }}" required />
                        </div>

                        <!-- Cuisine -->
                        <div>
                            <x-label for="cuisine_type" value="Type de cuisine" />
                            <select name="cuisine_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                @foreach(['Française', 'Italienne', 'Japonaise', 'Marocaine', 'Indienne'] as $type)
                                    <option value="{{ $type }}" {{ $restaurant->cuisine_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Capacité -->
                        <div>
                            <x-label for="capacity" value="Capacité (couverts)" />
                            <x-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" value="{{ old('capacity', $restaurant->capacity) }}" required />
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <x-label for="description" value="Description" />
                        <textarea name="description" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $restaurant->description) }}</textarea>
                    </div>

                    <!-- Horaires -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Horaires d'ouverture</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @php
                                $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                                $horaires = $restaurant->opening_hours ?? [];
                            @endphp
                            @foreach($jours as $jour)
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                    <span class="font-medium text-gray-700 w-24">{{ $jour }}</span>
                                    <x-input type="text" name="opening_hours[{{ $jour }}]" 
                                             value="{{ $horaires[$jour] ?? '' }}" 
                                             class="text-sm w-full ml-4" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Photos actuelles -->
                    @if($restaurant->photos->isNotEmpty())
                        <div class="mt-8">
                            <x-label value="Photos actuelles" />
                            <div class="grid grid-cols-4 gap-4 mt-2">
                                @foreach($restaurant->photos as $photo)
                                    <div class="relative group">
                                        <img src="{{ $photo->url }}" class="h-20 w-full object-cover rounded-lg border">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Ajouter de nouvelles photos -->
                    <div class="mt-8">
                        <x-label value="Ajouter de nouvelles photos" />
                        <input id="photos" name="photos[]" type="file" class="mt-1 block w-full" multiple>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t pt-6">
                        <a href="{{ route('restaurants.show', $restaurant) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Annuler</a>
                        <x-button class="bg-indigo-600 hover:bg-indigo-700">
                            {{ __('Enregistrer les modifications') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>