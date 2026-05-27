<?php

namespace App\Http\Controllers;

use App\Models\Finansai;
use Illuminate\Http\Request;
use App\Models\Kategorija;


class FinansaiController extends Controller
{
    public function index(Request $request)
    {
        $menuo = $request->menuo;
        $query = Finansai::with('kategorija');
        
        if ($menuo) {
                $query->whereRaw(
                "DATE_FORMAT(data, '%Y-%m') = ?",
                [$menuo]
            );
        }

        $irasai = $query
            ->latest('data')
            ->get();

        $kategorijos = Kategorija::all();

        $pajamos = (clone $query)
            ->where('tipas', 'Pajamos')
            ->sum('suma');

        $islaidos = (clone $query)
            ->where('tipas', 'Išlaidos')
            ->sum('suma');

        $likutis = $pajamos - $islaidos;

        $menesiList = Finansai::selectRaw("DATE_FORMAT(data, '%Y-%m') as menuo")
            ->distinct()
            ->orderBy('menuo')
            ->pluck('menuo');

        return view(
            'finansai_layout.finansai',
            compact(
                'irasai',
                'kategorijos',
                'pajamos',
                'islaidos',
                'likutis',
                'menesiList',
                'menuo'
            )
        );
    }
    public function store(Request $request)
    {
        $kategorija = Kategorija::findOrFail($request->kategorija_id);

        Finansai::create([
            'tipas' => $kategorija->tipas,
            'kategorija_id' => $request->kategorija_id,
            'suma' => $request->suma,
            'data' => $request->data,
            'aprasymas' => $request->aprasymas,
        ]);

        return redirect()->back();
        }

    public function update(Request $request, $id)
    {
        $irasas = Finansai::findOrFail($id);

        $kategorija = Kategorija::findOrFail($request->kategorija_id);

        $irasas->update([
            'tipas' => $kategorija->tipas,
            'kategorija_id' => $request->kategorija_id,
            'suma' => $request->suma,
            'data' => $request->data,
            'aprasymas' => $request->aprasymas,
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $irasas = Finansai::findOrFail($id);
        $irasas->delete();

        return redirect()->back();
    }
}
