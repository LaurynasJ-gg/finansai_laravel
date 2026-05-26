<?php

namespace App\Http\Controllers;

use App\Models\Finansai;
use Illuminate\Support\Facades\DB;

class SuvestineController extends Controller
{
    public function index()
    {
        $pajamos = Finansai::where('tipas', 'pajamos')->sum('suma');

        $islaidos = Finansai::where('tipas', 'islaidos')->sum('suma');

        $pagalKategorijas = Finansai::select(
                'kategorijos.pavadinimas',
                DB::raw('SUM(finansais.suma) as suma')
            )
            ->join('kategorijos', 'finansais.kategorija_id', '=', 'kategorijos.id')
            ->groupBy('kategorijos.pavadinimas')
            ->get();

        $pagalMenesi = Finansai::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as menuo"),
                DB::raw("SUM(suma) as suma")
            )
            ->groupBy('menuo')
            ->orderBy('menuo')
            ->get();

        return view('suvestine.index', compact(
            'pajamos',
            'islaidos',
            'pagalKategorijas',
            'pagalMenesi'
        ));
    }
}