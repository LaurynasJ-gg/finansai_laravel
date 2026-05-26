<x-app-layout>

    <div class="max-w-7xl mx-auto p-6">

        <h1 class="text-3xl font-bold mb-6">
            Suvestinė
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

            <div class="bg-white p-5 rounded-xl shadow">
                <h2 class="text-green-700 font-bold text-lg">
                    Pajamos
                </h2>

                <p class="text-3xl font-semibold mt-2">
                    €{{ number_format($pajamos, 2) }}
                </p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow">
                <h2 class="text-lg font-bold text-red-700">
                    Išlaidos
                </h2>

                <p class="text-3xl font-semibold mt-2">
                    €{{ number_format($islaidos, 2) }}
                </p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow">
                <h2 class="text-lg font-bold text-blue-700">
                    Likutis
                </h2>

                <p class="text-3xl font-semibold mt-2">
                    €{{ number_format($pajamos - $islaidos, 2) }}
                </p>
            </div>

        </div>

    </div>

</x-app-layout>

