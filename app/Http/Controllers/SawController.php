<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kategori;

class SawController extends Controller
{
    public function index()
    {

        try {
            return view('hasil-seleksi.saw', $this->saw());
        } catch (\Throwable) {
            return view('hasil-seleksi.error');
        }
    }

    private function saw()
    {
        $alternatives = Alternatif::all('id', 'nama', 'alamat', 'jenisKelamin')->load('kategories:kategori,atribut,bobot');
        $alternatives->setHidden(['id']);
        $kategories = Kategori::all('id', 'kategori', 'bobot');

        $data = array(array());
        $attributes = array();
        $bobotKategori = array();
        $row = 0;

        foreach ($alternatives as $alternatif) {
            $col = 0;
            foreach ($alternatif->kategories as $kategori) {
                $data[$row][$col] = $kategori->pivot->nilai;
                $col++;
            }
            $row++;
        }
        foreach ($alternatives as $alternatif) {
            $col = 0;
            foreach ($alternatif->kategories as $kategori) {
                $attributes[$col] = $kategori->atribut;
                $col++;
            }
        }
        foreach ($kategories as $kategori) {
            $bobotKategori[] = $kategori->bobot;
        }

        $normalisasi = $this->normalisasi($data, $attributes);
        $ranking = $this->perankingan($normalisasi, $bobotKategori);

        $alternatives->setHidden(['id', 'kategories', 'alamat', 'jenisKelamin']);
        $num = 0;
        foreach ($alternatives as $alternatif) {
            $alternatif->normalisasi = $normalisasi[$num];
            $alternatif->dataBobot = $ranking['dataBobot'][$num];
            $alternatif->ranking = $ranking['finalValue'][$num];
            $ranking['finalValue'][$num] = [
                'nama' => $alternatif->nama,
                'bobot' => $ranking['finalValue'][$num]
            ];
            $num++;
        }

        $rankings = $this->ranking($ranking['finalValue']);

        return ['alternatives' => $alternatives, 'rankings' => $rankings, 'kategories' => $kategories];
    }

    private function normalisasi($data, $attributes)
    {
        $nilaiAtribut = array();
        $cost = function ($atribut) {
            return $atribut == 'cost';
        };

        //col
        $i = 0;
        foreach ($attributes as $attribute) {
            $temp = 0;

            //row
            for ($j = 0; $j < count($data); $j++) {

                if ($j === 0) {
                    $temp = $data[$j][$i];
                    continue;
                }

                if ($cost($attribute)) {
                    $temp = ($temp < $data[$j][$i]) ?  $temp : $data[$j][$i];
                } else {
                    $temp = ($temp > $data[$j][$i]) ? $temp : $data[$j][$i];
                }
            }

            $nilaiAtribut[] = $temp;
            unset($temp);
            $i++;
        }

        //col
        $i = 0;
        foreach ($attributes as  $attribute) {

            //row
            for ($j = 0; $j < count($data); $j++) {

                if ($cost($attribute)) {
                    $data[$j][$i] = round($nilaiAtribut[$i] / (float)$data[$j][$i], 3);
                } else {
                    $data[$j][$i] = round((float)$data[$j][$i] / $nilaiAtribut[$i], 3);
                }
            }

            $i++;
        }

        return $data;
    }

    private function perankingan($normalisasi, $kategories)
    {
        $temp = array();
        $dataBobot = array();
        $finalValue = array();
        //row
        for ($i = 0; $i < count($normalisasi); $i++) {

            //col
            $sum = 0;
            for ($j = 0; $j < count($kategories); $j++) {
                $sum += ($normalisasi[$i][$j] * $kategories[$j]);
                $temp[] = round($normalisasi[$i][$j] * $kategories[$j], 2);
            }

            $dataBobot[] = $temp;
            unset($temp);
            $finalValue[] = round($sum, 2);
        }
        unset($temp);

        return ['finalValue' => $finalValue, 'dataBobot' => $dataBobot];
    }

    private function ranking($alternatives)
    {
        for ($i = 0; $i < count($alternatives) - 1; $i++) {
            for ($j = 0; $j < count($alternatives) - 1; $j++) {
                if ($alternatives[$j]['bobot'] < $alternatives[$j + 1]['bobot']) {
                    $temp = $alternatives[$j];
                    $alternatives[$j] = $alternatives[$j + 1];
                    $alternatives[$j + 1] = $temp;
                }
            }
        }

        return $alternatives;
    }
}
