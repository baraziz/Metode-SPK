<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kategori;
use Illuminate\Http\Request;

class NilaiAlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatives = Alternatif::all('id', 'nama');
        $alternatives->load('kategories');
        $kategories = Kategori::all('kategori');

        $kolomKategori = count($kategories);

        // return $alternatives;

        return view('nilai-alternatif.table-nilai-alternatif', [
            'alternatives' => $alternatives,
            'kategories' => $kategories,
            'kolomKategori' => $kolomKategori
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Alternatif $alternatif)
    {
        $kategories = Kategori::all('kategori');

        return view('nilai-alternatif.edit', [
            'alternatif' => $alternatif,
            'kategories' => $kategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alternatif $alternatif)
    {
        $rules = array();
        $kategori_id = array();

        foreach (Kategori::all('id', 'kategori') as $kategori) {
            $name = str_replace(' ', '', $kategori->kategori);
            $rules["$name"] = "required|numeric|between:1,10";
            $kategori_id["$name"] = $kategori->id;
        }

        $validatedData = $request->validate($rules);

        $dataInput = array();
        foreach ($validatedData as $key => $value) {
            $dataInput[$kategori_id[$key]] = ['nilai' => $value];
        }

        $alternatif->kategories()->detach();
        $alternatif->kategories()->attach($dataInput);

        return redirect()->route('nilai-alternatif.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
