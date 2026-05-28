<?php

namespace App\Http\Controllers;

use App\Models\Finansai;
use Illuminate\Http\Request;
use App\Models\Kategorija;
use Illuminate\Support\Facades\Auth;

class FinansaiController extends Controller
{
    public function index(Request $request)
    {
        $menuo = $request->menuo;

        $query = Finansai::with('kategorija')->where('user_id', Auth::id());

        if ($menuo) { $query->whereRaw("DATE_FORMAT(data, '%Y-%m') = ?", [$menuo]);}

        $irasai = (clone $query)->latest('data')->get();

        $kategorijos = Kategorija::all();

        $pajamos = (clone $query)->where('tipas', 'pajamos')->sum('suma');
        $islaidos = (clone $query)->where('tipas', 'islaidos')->sum('suma');
        $likutis = $pajamos - $islaidos;

        $menesiList = Finansai::where('user_id', Auth::id())
            ->selectRaw("DATE_FORMAT(data, '%Y-%m') as menuo")
            ->distinct()
            ->orderBy('menuo')
            ->pluck('menuo');

        return view('finansai_layout.finansai', compact(
            'irasai',
            'kategorijos',
            'pajamos',
            'islaidos',
            'likutis', 
            'menesiList',
            'menuo'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategorija_id' => 'required|exists:kategorijos,id',
            'suma'          => 'required|numeric|min:0.01',
            'data'          => 'required|date',
            'aprasymas'     => 'nullable|string|max:500',
        ]);

        $kategorija = Kategorija::findOrFail($request->kategorija_id);

        Finansai::create([
            'user_id'      => Auth::id(),
            'tipas'        => $kategorija->tipas,
            'kategorija_id'=> $request->kategorija_id,
            'suma'         => $request->suma,
            'data'         => $request->data,
            'aprasymas'    => $request->aprasymas,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategorija_id' => 'required|exists:kategorijos,id',
            'suma'          => 'required|numeric|min:0.01',
            'data'          => 'required|date',
            'aprasymas'     => 'nullable|string|max:500',
        ]);

        $irasas = Finansai::where('user_id', Auth::id())->findOrFail($id);
        $kategorija = Kategorija::findOrFail($request->kategorija_id);

        $irasas->update([
            'tipas'        => $kategorija->tipas,
            'kategorija_id'=> $request->kategorija_id,
            'suma'         => $request->suma,
            'data'         => $request->data,
            'aprasymas'    => $request->aprasymas,
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $irasas = Finansai::where('user_id', Auth::id())->findOrFail($id);
        $irasas->delete();

        return redirect()->back();
    }
}