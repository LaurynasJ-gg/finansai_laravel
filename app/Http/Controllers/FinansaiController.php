<?php

namespace App\Http\Controllers;

use App\Models\Finansai;
use Illuminate\Http\Request;
use App\Models\Kategorija;


class FinansaiController extends Controller
{
    public function index()
    {
        $irasai = Finansai::with('kategorija')->latest()->get();
        $kategorijos = Kategorija::all();

        $pajamos = Finansai::where('tipas', 'Pajamos')->sum('suma');

        $islaidos = Finansai::where('tipas', 'Išlaidos')->sum('suma');

        $likutis = $pajamos - $islaidos;

        return view(
            'finansai_layout.finansai',
            compact(
                'irasai',
                'kategorijos',
                'pajamos',
                'islaidos',
                'likutis'
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
