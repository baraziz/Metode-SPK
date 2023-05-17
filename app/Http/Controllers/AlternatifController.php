<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatifs = Alternatif::all('id', 'nama', 'jenisKelamin', 'alamat');

        // $alternatifs->toArray();

        return view('alternatif.table-alternatif', [
            'alternatifs' => $alternatifs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alternatif.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required',
            'jenisKelamin' => 'required',
            'alamat' => 'required'
        ]);

        Alternatif::create([
            'nama' => $validatedData['nama'],
            'jenisKelamin' => $validatedData['jenisKelamin'],
            'alamat' => $validatedData['alamat']
        ]);

        return redirect()->route('alternatif.index');
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
        $alternatif->setVisible(['id', 'nama', 'alamat', 'jeniskelamin']);
        return view('alternatif.edit', [
            'id' => $alternatif->id,
            'nama' => $alternatif->nama,
            'alamat' => $alternatif->alamat,
            'jenisKelamin' => $alternatif->jenisKelamin
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenisKelamin' => 'required',
            'alamat' => 'required'
        ]);

        Alternatif::where('id', $id)
            ->update([
                'nama' => $validatedData['nama'],
                'jenisKelamin' => $validatedData['jenisKelamin'],
                'alamat' => $validatedData['alamat']
            ]);

        return redirect()->route('alternatif.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alternatif $alternatif)
    {
        DB::transaction(function () use ($alternatif) {
            $alternatif->kategories()->detach();
            Alternatif::destroy($alternatif->id);
        });

        return redirect()->route('alternatif.index');
    }
}
