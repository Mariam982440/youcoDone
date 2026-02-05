<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publier un nouveau Restaurant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <x-label for="name" value="Nom du restaurant" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                        </div>

                        <!-- Ville -->
                        <div>
                            <x-label for="city" value="Ville" />
                            <x-input id="city" class="block mt-1 w-full" type="text" name="city" required />
                        </div>

                        <!-- Cuisine -->
                        <div>
                            <x-label for="cuisine_type" value="Type de cuisine" />
                            <select name="cuisine_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="Française">Française</option>
                                <option value="Italienne">Italienne</option>
                                <option value="Japonaise">Japonaise</option>
                                <option value="Marocaine">Marocaine</option>
                            </select>
                        </div>

                        <!-- Capacité -->
                        <div>
                            <x-label for="capacity" value="Capacité (couverts)" />
                            <x-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" required />
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <x-label for="description" value="Description" />
                        <textarea name="description" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"></textarea>
                    </div>

                    <!-- Horaires (Grid) -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Horaires d'ouverture</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $jour)
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                    <span class="font-medium text-gray-700 w-24">{{ $jour }}</span>
                                    <x-input type="text" name="opening_hours[{{ $jour }}]" placeholder="ex: 12h-15h, 19h-23h" class="text-sm w-full ml-4" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Photos -->
                    <div class="mt-8">
                        <x-label value="Photos du restaurant (Plusieurs possibles)" />
                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="photos" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Téléverser des fichiers</span>
                                        <input id="photos" name="photos[]" type="file" class="sr-only" multiple>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG jusqu'à 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton Submit -->
                    <div class="flex items-center justify-end mt-8 border-t pt-6">
                        <x-button class="ml-4 bg-green-600 hover:bg-green-700">
                            {{ __('Publier le Restaurant') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</form>
</x-app-layout>