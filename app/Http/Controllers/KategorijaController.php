<?php

namespace App\Http\Controllers;

use App\Models\Kategorija;
use Illuminate\Http\Request;

class KategorijaController extends Controller
{
    public function index()
    {
        $kategorijos = Kategorija::all();

        return view('kategorijos.index', compact('kategorijos'));
    }

    public function store(Request $request)
    {
        Kategorija::create([
            'pavadinimas' => $request->pavadinimas,
            'tipas' => $request->tipas,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $kategorija = Kategorija::findOrFail($id);

        $kategorija->update([
            'pavadinimas' => $request->pavadinimas,
            'tipas' => $request->tipas,
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $kategorija = Kategorija::findOrFail($id);

        $kategorija->delete();

        return redirect()->back();
    }
}