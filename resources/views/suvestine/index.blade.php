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

    <div class="bg-white p-6 rounded-xl shadow w-[500px] mx-auto">

        <h2 class="text-xl font-bold mb-4">
            Išlaidų grafikai
        </h2>
        
        <canvas id="pieChart" width="400" height="400"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </div>

    <script>

        const ctx = document.getElementById('pieChart');

        new Chart(ctx, {
            type: 'pie',

            data: {
                labels: ['Pajamos', 'Išlaidos'],

                datasets: [{
                    data: [
                        {{ $pajamos }},
                        {{ $islaidos }}
                    ],

                    backgroundColor: [
                        '#16a34a',
                        '#dc2626'
                    ],

                    borderWidth: 1
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });

    </script>
</x-app-layout>

