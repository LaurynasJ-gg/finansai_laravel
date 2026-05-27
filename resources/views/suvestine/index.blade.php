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

   <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-6xl mx-auto">


    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-4">
            Pajamos / Išlaidos
        </h2>

        <canvas id="pieChart"></canvas>

    </div>


    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-4">
            Kategorijų stulpelinė diagrama
        </h2>

        <canvas id="barChart"></canvas>

    </div>


    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-4">
            Mėnesio statistika
        </h2>

        <canvas id="lineChart"></canvas>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                ]
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

    const barCtx = document.getElementById('barChart');

    new Chart(barCtx, {
        type: 'bar',

        data: {
            labels: @json($pagalKategorijas->pluck('pavadinimas')),

            datasets: [{
                label: 'Suma pagal kategorijas',

                data: @json($pagalKategorijas->pluck('suma')),

                 backgroundColor: [
                '#16a34a',
                '#dc2626',
                '#dc2626',
                '#dc2626',
                '#dc2626',
                '#dc2626',
                '#dc2626',
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

    const lineCtx = document.getElementById('lineChart');

        new Chart(lineCtx, {
            type: 'line',

        data: {
            labels: @json($pagalMenesi->pluck('menuo')),

            datasets: [
                {
                    label: 'Pajamos',
                    data: @json($pagalMenesi->pluck('pajamos')),
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22,163,74,0.2)',
                    tension: 0.4,
                fill: false
                },

                {
                    label: 'Išlaidos',
                    data: @json($pagalMenesi->pluck('islaidos')),
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220,38,38,0.2)',
                    tension: 0.4,
                fill: false
                }
            ]   
        },

        options: {
            responsive: true,

            scales: {
                y: {beginAtZero: true}
            }
        }
    });

</script>

</x-app-layout>

