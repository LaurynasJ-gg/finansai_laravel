<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Suvestinė</title>

    <style>
        body {font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 13px;}
        h1 {margin-bottom: 5px;}
        .periodas {margin-bottom: 25px; color: #555;}
        .korteles {width: 100%; margin-bottom: 25px;}
        .korteles td {width: 33.33%; padding: 12px; border: 1px solid #ddd;}
        .label { font-weight: bold; margin-bottom: 8px;}
        .suma {font-size: 20px; font-weight: bold;}
        table {width: 100%; border-collapse: collapse; margin-top: 15px;}
        th, td {border: 1px solid #ddd; padding: 8px;}
        th {background: #f3f4f6; text-align: left;}
        .right {text-align: right;}
        .pajamos {color: #000000;}
        .islaidos {color: #000000;}
    </style>
</head>
<body>

    <h1>Finansų suvestinė</h1>

    <div class="periodas">
        Periodas:
        <b>{{ $menuo ? $menuo : 'Visi mėnesiai' }}</b>
    </div>

    <table class="korteles">
        <tr>
            <td>
                <div class="label pajamos">Pajamos</div>
                <div class="suma">€{{ number_format($pajamos, 2) }}</div>
            </td>

            <td>
                <div class="label islaidos">Išlaidos</div>
                <div class="suma">€{{ number_format($islaidos, 2) }}</div>
            </td>

            <td>
                <div class="label">Likutis</div>
                <div class="suma">€{{ number_format($pajamos - $islaidos, 2) }}</div>
            </td>
        </tr>
    </table>

    <h2>Sumos pagal kategorijas</h2>

    <table>
        <thead>
            <tr>
                <th>Kategorija</th>
                <th class="right">Suma</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pagalKategorijas as $kategorija)
                <tr>
                    <td>{{ $kategorija->pavadinimas }}</td>
                    <td class="right">€{{ number_format($kategorija->suma, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Duomenų nėra.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Įrašai</h2>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Tipas</th>
                <th>Kategorija</th>
                <th>Aprašymas</th>
                <th class="right">Suma</th>
            </tr>
        </thead>

        <tbody>
            @forelse($irasai as $irasas)
                <tr>
                    <td>{{ $irasas->data }}</td>
                    <td>{{ ucfirst($irasas->tipas) }}</td>
                    <td>{{ $irasas->kategorija->pavadinimas ?? '-' }}</td>
                    <td>{{ $irasas->aprasymas ?? '-' }}</td>
                    <td class="right">€{{ number_format($irasas->suma, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Įrašų nėra.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>