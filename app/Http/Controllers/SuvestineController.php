<?php

namespace App\Http\Controllers;

use App\Models\Finansai;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SuvestineController extends Controller
{
    public function index(Request $request)
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

        $pagalKategorijas = (clone $query)
            ->select('kategorijos.pavadinimas', DB::raw('SUM(finansais.suma) as suma'))
            ->join('kategorijos', 'finansais.kategorija_id', '=', 'kategorijos.id')
            ->groupBy('kategorijos.pavadinimas')
            ->get();

        $pagalMenesi = Finansai::select(
                DB::raw("DATE_FORMAT(data, '%Y-%m') as menuo"),

                DB::raw("
                    COALESCE(SUM(
                        CASE
                            WHEN tipas = 'pajamos'
                            THEN suma
                            ELSE 0
                        END
                    ),0) as pajamos
                "),

                DB::raw("
                    COALESCE(SUM(
                        CASE
                            WHEN tipas = 'islaidos'
                            THEN suma
                            ELSE 0
                        END
                    ),0) as islaidos
                ")
            )
            ->groupBy('menuo')
            ->orderBy('menuo')
            ->get();

        $menesiList = Finansai::selectRaw("
                DATE_FORMAT(data, '%Y-%m') as menuo
            ")
            ->distinct()
            ->orderBy('menuo')
            ->pluck('menuo');

        return view('suvestine.index', compact(
            'pajamos',
            'islaidos',
            'pagalKategorijas',
            'pagalMenesi',
            'menesiList',
            'menuo'
        ));
    }
}