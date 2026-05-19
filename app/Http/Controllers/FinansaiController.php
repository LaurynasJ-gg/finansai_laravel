<?php

namespace App\Http\Controllers;

use App\Models\Finansai;
use Illuminate\Http\Request;

class FinansaiController extends Controller
{
    public function index()
    {
        $irasai = Finansai::latest()->get();

        return view('finansai_layout.finansai', compact('irasai'));
    }

    public function store(Request $request)
    {
        Finansai::create([
            'tipas' => $request->tipas,
            'kategorija' => $request->kategorija,
            'suma' => $request->suma,
            'aprasymas' => $request->aprasymas,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $irasas = Finansai::findOrFail($id);

        $irasas->update([
            'tipas' => $request->tipas,
            'kategorija' => $request->kategorija,
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
