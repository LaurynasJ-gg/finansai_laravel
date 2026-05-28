<?php

namespace App\Http\Controllers;

use App\Models\Finansai;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class SuvestineController extends Controller
{
    public function index(Request $request)
    {
        $duomenys = $this->gautiSuvestinesDuomenis($request);

        return view('suvestine.index', $duomenys);
    }

    public function pdf(Request $request)
    {
        $duomenys = $this->gautiSuvestinesDuomenis($request);
        $pdf = Pdf::loadView('suvestine.pdf', $duomenys);
        $failoPavadinimas = $duomenys['menuo']
            ? 'suvestine-' . $duomenys['menuo'] . '.pdf'
            : 'visa-suvestine.pdf';
        return $pdf->download($failoPavadinimas);
    }
    private function gautiSuvestinesDuomenis(Request $request)
    {
        $menuo = $request->menuo;
        $query = Finansai::query();

        if ($menuo) {
            $query->whereRaw("DATE_FORMAT(data, '%Y-%m') = ?", [$menuo]);
        }

        $pajamos = (clone $query)
            ->where('tipas', 'pajamos')
            ->sum('suma');

        $islaidos = (clone $query)
            ->where('tipas', 'islaidos')
            ->sum('suma');

        $irasai = (clone $query)
            ->with('kategorija')
            ->orderBy('data', 'desc')
            ->get();

        $pagalKategorijas = (clone $query)
            ->select('kategorijos.pavadinimas', DB::raw('SUM(finansais.suma) as suma'))
            ->join('kategorijos', 'finansais.kategorija_id', '=', 'kategorijos.id')
            ->groupBy('kategorijos.pavadinimas')
            ->get();

        $pagalMenesiQuery = Finansai::query();

        if ($menuo) {
            $pagalMenesiQuery->whereRaw("DATE_FORMAT(data, '%Y-%m') = ?", [$menuo]);
        }

        $pagalMenesi = $pagalMenesiQuery
            ->select(
                DB::raw("DATE_FORMAT(data, '%Y-%m') as menuo"),
                DB::raw("COALESCE(SUM(CASE WHEN tipas = 'pajamos' THEN suma ELSE 0 END),0) as pajamos"),
                DB::raw("COALESCE(SUM(CASE WHEN tipas = 'islaidos' THEN suma ELSE 0 END),0) as islaidos")
            )

            ->groupBy('menuo')
            ->orderBy('menuo')
            ->get();

        $menesiList = Finansai::selectRaw("DATE_FORMAT(data, '%Y-%m') as menuo")
            ->distinct()
            ->orderBy('menuo')
            ->pluck('menuo');

        return compact(
            'pajamos',
            'islaidos',
            'pagalKategorijas',
            'pagalMenesi',
            'menesiList',
            'menuo',
            'irasai'
        );
    }

    public function siustiPdf(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'menuo' => 'nullable'
        ]);

        $duomenys = $this->gautiSuvestinesDuomenis($request);

        $pdf = Pdf::loadView('suvestine.pdf', $duomenys);

        $failoPavadinimas = $duomenys['menuo']
            ? 'suvestine-' . $duomenys['menuo'] . '.pdf'
            : 'visa-suvestine.pdf';

        Mail::send([], [], function ($message) use ($request, $pdf, $failoPavadinimas, $duomenys) {
        $periodas = $duomenys['menuo'] ? $duomenys['menuo'] : 'Visi mėnesiai';

            $message
            ->to($request->email)
            ->subject('Finansų suvestinė PDF')
            ->html('Sveiki,<br><br>PDF faile rasite finansų suvestinę.<br><br>Periodas: <b>' . $periodas . '</b>')
            ->attachData(
                $pdf->output(),
                $failoPavadinimas,
                ['mime' => 'application/pdf']
            );
        });

    return back()->with('success', 'PDF suvestinė išsiųsta el. paštu.');
}
}