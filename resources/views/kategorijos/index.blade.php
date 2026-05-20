<x-app-layout>

<div class="p-6 max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">
        Kategorijos
    </h1>

    <!-- Pridėjimo forma -->

    <div class="bg-white p-4 rounded shadow mb-6">

        <form action="{{ route('kategorijos.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                <input
                    type="text"
                    name="pavadinimas"
                    placeholder="Kategorijos pavadinimas"
                    class="border rounded p-2"
                    required
                >

                <select
                    name="tipas"
                    class="border rounded p-2"
                >
                    <option value="pajamos">Pajamos</option>
                    <option value="islaidos">Išlaidos</option>
                </select>

                <button
                    type="submit"
                    class="bg-blue-500 text-white rounded px-4 py-2"
                >
                    Pridėti
                </button>

            </div>

        </form>

    </div>

    <!-- Lentelė -->

    <div class="bg-white p-4 rounded shadow overflow-x-auto">

        <table class="w-full border-collapse border">

            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Pavadinimas</th>
                    <th class="border p-2">Tipas</th>
                    <th class="border p-2">Veiksmai</th>
                </tr>
            </thead>

            <tbody>

                @foreach($kategorijos as $kategorija)

                <tr>

                    <td class="border p-2">
                        {{ $kategorija->pavadinimas }}
                    </td>

                    <td class="border p-2">
                        {{ $kategorija->tipas }}
                    </td>

                    <td class="border p-2">

                        <!-- Mygtukai -->

                        <div
                            id="buttons-{{ $kategorija->id }}"
                            class="flex gap-2"
                        >

                            <!-- Redaguoti -->

                            <button
                                type="button"
                                onclick="
                                    document.getElementById('edit-{{ $kategorija->id }}').classList.remove('hidden');
                                    document.getElementById('buttons-{{ $kategorija->id }}').classList.add('hidden');
                                "
                                class="bg-yellow-500 text-white px-3 py-1 rounded text-sm"
                            >
                                Redaguoti
                            </button>

                            <!-- Trinti -->

                            <form
                                action="{{ route('kategorijos.destroy', $kategorija->id) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded text-sm"
                                >
                                    Trinti
                                </button>

                            </form>

                        </div>

                        <!-- Redagavimo forma -->

                        <div
                            id="edit-{{ $kategorija->id }}"
                            class="hidden mt-3 border rounded p-3 bg-gray-50"
                        >

                            <form
                                action="{{ route('kategorijos.update', $kategorija->id) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">

                                    <!-- Pavadinimas -->

                                    <input
                                        type="text"
                                        name="pavadinimas"
                                        value="{{ $kategorija->pavadinimas }}"
                                        class="border rounded p-2"
                                        required
                                    >

                                    <!-- Tipas -->

                                    <select
                                        name="tipas"
                                        class="border rounded p-2"
                                    >

                                        <option
                                            value="pajamos"
                                            {{ $kategorija->tipas == 'pajamos' ? 'selected' : '' }}
                                        >
                                            Pajamos
                                        </option>

                                        <option
                                            value="islaidos"
                                            {{ $kategorija->tipas == 'islaidos' ? 'selected' : '' }}
                                        >
                                            Išlaidos
                                        </option>

                                    </select>

                                    <!-- Mygtukai -->

                                    <div class="flex gap-2">

                                        <button
                                            type="submit"
                                            class="bg-green-500 text-white rounded px-4 py-2"
                                        >
                                            Išsaugoti
                                        </button>

                                        <button
                                            type="button"
                                            onclick="
                                                document.getElementById('edit-{{ $kategorija->id }}').classList.add('hidden');
                                                document.getElementById('buttons-{{ $kategorija->id }}').classList.remove('hidden');
                                            "
                                            class="bg-gray-500 text-white rounded px-4 py-2"
                                        >
                                            Atšaukti
                                        </button>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>