<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto">

            <h1 class="text-3xl font-bold mb-6">
                Finansų programa
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="text-lg font-bold text-green-700">
                Pajamos
            </h2>

            <p class="text-3xl font-semibold mt-2">
                {{ number_format($pajamos, 2) }} €
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="text-lg font-bold text-red-700">
                Išlaidos
            </h2>

            <p class="text-3xl font-semibold mt-2">
                {{ number_format($islaidos, 2) }} €
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="text-lg font-bold text-blue-700">
                Likutis
            </h2>

            <p class="text-3xl font-semibold mt-2">
                {{ number_format($likutis, 2) }} €
            </p>
        </div>

    </div>

        <!-- forma -->

        <div class="bg-white p-6 rounded shadow mb-8">

            <form action="{{ route('finansai.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Kategorija</label>

                    <select
                        name="kategorija_id"
                        class="w-full border rounded p-2 pr-8"
                        required
                    >

                        @foreach($kategorijos as $kategorija)

                            <option value="{{ $kategorija->id }}">
                                {{ $kategorija->pavadinimas }} ({{ $kategorija->tipas }})
                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Suma</label>

                    <input
                        type="number"
                        step="0.01"
                        name="suma"
                        class="w-full border rounded p-2"
                        placeholder="0.00"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Aprasymas</label>

                    <textarea
                        name="aprasymas"
                        class="w-full border rounded p-2"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded"
                >
                    Pridėti įrašą
                </button>

            </form>

        </div>


        <!-- cia irasai -->

        <div class="bg-white p-6 rounded shadow overflow-x-auto">

            <table class="w-full table-auto border-collapse border">

                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Tipas</th>
                        <th class="border p-2">Kategorija</th>
                        <th class="border p-2">Suma</th>
                        <th class="border p-2">Aprašymas</th>
                        <th class="border p-2">Veiksmai</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($irasai as $irasas)

                    <tr>

                        <td class="border p-2">
                            {{ $irasas->tipas }}
                        </td>

                        <td class="border p-2">
                             {{ $irasas->kategorija->pavadinimas ?? '-' }}
                        </td>

                        <td class="border p-2">
                            €{{ number_format($irasas->suma, 2) }}
                        </td>

                        <td class="border p-2">
                            {{ $irasas->aprasymas }}
                        </td>

                        <td class="border p-2">


                            <div class="flex gap-2">

                                <button
                                    onclick="document.getElementById('edit-{{ $irasas->id }}').classList.toggle('hidden')"
                                    class="bg-yellow-500 text-white px-2 py-1 text-sm rounded"
                                >
                                    Redaguoti
                                </button>

                                <form
                                    action="{{ route('finansai.delete', $irasas->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="bg-red-500 text-white px-2 py-1 text-sm rounded"
                                    >
                                        Trinti
                                    </button>

                                </form>

                            </div>


                            <!-- cia koregavimo forma -->

                            <div
                                id="edit-{{ $irasas->id }}"
                                class="hidden mt-3 border rounded p-3 bg-gray-50"
                            >

                                <form
                                    action="{{ route('finansai.update', $irasas->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

                                        <select
                                            name="kategorija_id"
                                            class="border rounded p-2 pr-8 text-sm"
                                        >      

                                            @foreach($kategorijos as $kategorija)

                                                <option
                                                    value="{{ $kategorija->id }}"
                                                    {{ $irasas->kategorija_id == $kategorija->id ? 'selected' : '' }}
                                                >
                                                    {{ $kategorija->pavadinimas }}
                                                </option>

                                            @endforeach

                                        </select>

                                        <input
                                            type="number"
                                            step="0.01"
                                            name="suma"
                                            value="{{ $irasas->suma }}"
                                            class="border rounded p-2 text-sm"
                                        >

                                        <textarea
                                            name="aprasymas"
                                            class="border rounded p-2 text-sm"
                                            rows="2"
                                        >{{ $irasas->aprasymas }}</textarea>

                                    </div>

                                    <button
                                        type="submit"
                                        class="mt-2 bg-green-500 text-white px-3 py-1 text-sm rounded"
                                    >
                                        Išsaugoti
                                    </button>

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