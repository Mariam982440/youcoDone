<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gérer les fermetures : {{ $restaurant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Formulaire d'ajout -->
                <div class="mb-10">
                    <h3 class="text-lg font-bold mb-4">Bloquer une date de réservation</h3>
                    <form action="{{ route('closures.store', $restaurant) }}" method="POST" class="flex gap-4 items-end">
                        @csrf
                        <div class="flex-1">
                            <x-label for="closed_date" value="Date à fermer" />
                            <x-input id="closed_date" type="date" name="closed_date" class="block mt-1 w-full" required />
                        </div>
                        <div class="flex-1">
                            <x-label for="reason" value="Raison (optionnel)" />
                            <x-input id="reason" type="text" name="reason" placeholder="Ex: Travaux" class="block mt-1 w-full" />
                        </div>
                        <x-button class="bg-red-600 hover:bg-red-700">Bloquer la date</x-button>=
                    </form>
                </div>

                <!-- Liste des dates fermées -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Dates actuellement bloquées</h3>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-100 uppercase text-xs font-bold text-gray-600">
                                <tr>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Raison</th>
                                    <th class="px-4 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($closures as $closure)
                                    <tr>
                                        <td class="px-4 py-3 font-medium">{{ \Carbon\Carbon::parse($closure->closed_date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-gray-500">{{ $closure->reason ?? '-' }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <form action="{{ route('closures.destroy', $closure) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="text-blue-600 hover:underline">Réouvrir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-gray-400 italic">
                                            Aucune fermeture exceptionnelle programmée.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>