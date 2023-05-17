<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all('id', 'kategori', 'atribut', 'bobot');

        $bobotPersen = 0;
        foreach ($kategoris as $kategori) {
            $bobotPersen = $bobotPersen + $kategori->bobot;
        }
        foreach ($kategoris as $kategori) {
            $kategori->bobotPersen = round(($kategori->bobot / $bobotPersen) * 100, 1);
        }


        return view('kriteria.table-kriteria', [
            'kategoris' => $kategoris
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kriteria' => 'required',
            'atribut' => 'required',
            'bobot' => 'required|integer|min:1|max:10'
        ]);

        Kategori::create([
            'kategori' => $validatedData['kriteria'],
            'atribut' => $validatedData['atribut'],
            'bobot' => $validatedData['bobot']
        ]);

        return redirect()->route('kriteria.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        $kategori->setVisible(['id', 'kategori', 'atribut', 'bobot']);
        return view('kriteria.edit', ['kriteria' => $kategori]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'kriteria' => 'required',
            'atribut' => 'required',
            'bobot' => 'required|integer|min:1|max:10'
        ]);

        Kategori::where('id', $id)
            ->update([
                'kategori' => $validatedData['kriteria'],
                'atribut' => $validatedData['atribut'],
                'bobot' => $validatedData['bobot']
            ]);

        return redirect()->route('kriteria.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        DB::transaction(function () use ($kategori) {
            $kategori->alternatives()->detach();
            Kategori::destroy($kategori->id);
        }, 5);

        return redirect()->route('kriteria.index');
    }
}
