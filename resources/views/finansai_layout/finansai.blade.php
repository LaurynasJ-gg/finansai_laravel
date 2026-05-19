<x-app-layout>

    <div class="p-6 max-w-6xl mx-auto">

        <h1 class="text-3xl font-bold mb-6">
            Finansų programa
        </h1>

        <!-- PRIDĖJIMO FORMA -->

        <div class="bg-white p-6 rounded shadow mb-8">

            <form action="{{ route('finansai.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1">Tipas</label>

                    <select name="tipas" class="w-full border rounded p-2">
                        <option value="Pajamos">Pajamos</option>
                        <option value="Išlaidos">Išlaidos</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Kategorija</label>

                    <input
                        type="text"
                        name="kategorija"
                        class="w-full border rounded p-2"
                        placeholder="Pvz: Maistas"
                        required
                    >
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
                    <label class="block mb-1">Aprašymas</label>

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


        <!-- ĮRAŠŲ LENTELĖ -->

        <div class="bg-white p-6 rounded shadow">

            <table class="w-full table-auto border-collapse border">

                <thead>
                    <tr class="bg-g ray-200">
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

                        <form action="{{ route('finansai.update', $irasas->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <td class="border p-2">
                                <select name="tipas" class="border rounded p-1">
                                    <option value="Pajamos"
                                        {{ $irasas->tipas == 'Pajamos' ? 'selected' : '' }}>
                                        Pajamos
                                    </option>

                                    <option value="Išlaidos"
                                        {{ $irasas->tipas == 'Išlaidos' ? 'selected' : '' }}>
                                        Išlaidos
                                    </option>
                                </select>
                            </td>

                            <td class="border p-2">
                                <input  
                                    type="text"
                                    name="kategorija"
                                    value="{{ $irasas->kategorija }}"
                                    class="border rounded p-1"
                                >
                            </td>

                            <td class="border p-2">
                                <input
                                    type="number"
                                    step="0.01"
                                    name="suma"
                                    value="{{ $irasas->suma }}"
                                    class="border rounded p-1"
                                >
                            </td>

                            <td class="border p-2">
                                <input
                                    type="text"
                                    name="aprasymas"
                                    value="{{ $irasas->aprasymas }}"
                                    class="border rounded p-1"
                                >
                            </td>

                            <td class="border p-2">
                                <div class="flex gap-2"> 
                                <button
                                    type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded"
                                >
                                    Redaguoti
                                </button>

                        </form>


                        <form action="{{ route('finansai.delete', $irasas->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded"
                            >
                                Trinti
                            </button>
                        </form>

                            </td>
                        </div>

                    </tr>

                    @endforeach

                </tbody>

            </table >

        </div>

    </div>

</x-app-layout>