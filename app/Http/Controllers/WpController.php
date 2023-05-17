<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kategori;

class WpController extends Controller
{
    public function index()
    {
        // return $this->wp();
        // return $wp = collect($this->wp());
        $wp = collect($this->wp());
        try {
            return view('hasil-seleksi.wp', $wp);
        } catch (\Throwable) {
            return view('hasil-seleksi.error');
        }
    }

    private function wp()
    {
        $kategories = Kategori::all('id', 'kategori', 'atribut', 'bobot');
        $alternatives = Alternatif::all('id', 'nama', 'alamat', 'jenisKelamin')
            ->load('kategories:kategori,atribut,bobot');
        $alternatives->setHidden(['id']);

        $bobot_w = collect($this->bobot_w($kategories));
        $bobot_s = $this->bobot_s($alternatives, $bobot_w);
        $bobot_v = $this->bobot_v($bobot_s);
        $rankings = $this->ranking_v($bobot_v);

        return ["bobot_w" => $bobot_w, "bobot_s" => $bobot_s, "bobot_v" => $bobot_v, 'rankings' => $rankings];
    }

    private function bobot_w($kategories)
    {
        $sum = 0;
        foreach ($kategories as $kategori) {
            $sum += $kategori->bobot;
        }

        $temp_w = array();
        foreach ($kategories as $kategori) {
            $temp_w[] = [
                'kategori' => $kategori->kategori,
                'atribut' => $kategori->atribut,
                'bobot_w' => round(($kategori->bobot / $sum), 3)
            ];
        }
        unset($sum);

        $bobot_w = array();
        foreach ($temp_w as $temp) {

            $bobot = ($temp['atribut'] == 'benefit') ?  $temp['bobot_w'] * 1 : $temp['bobot_w'] * (-1);

            $bobot_w[] = [
                'kategori' => $temp['kategori'],
                'atribut' => $temp['atribut'],
                'bobot_w' => $bobot
            ];
            unset($bobot);
        }

        return $bobot_w;
    }

    private function bobot_s($alternatives, $bobot_w)
    {
        $bobot_s = array();
        $normalisasi_s = array();

        foreach ($alternatives as $alternatif) {

            $num = 0;
            $temp = 1;
            foreach ($alternatif->kategories as $kategori) {
                $normalisasi_s[] = round(pow($kategori->pivot->nilai, $bobot_w[$num]['bobot_w']), 3);
                $temp *= pow($kategori->pivot->nilai, $bobot_w[$num]['bobot_w']);
                $num++;
            }
            $bobot_s[] = [
                'nama' => $alternatif->nama,
                'normalisasi' => $normalisasi_s,
                'bobot_s' => round($temp, 3)
            ];
            unset($normalisasi_s);
        }

        return $bobot_s;
    }

    private function bobot_v($bobot_s)
    {
        $normalisasi_v = array();

        $sum = 0;
        foreach ($bobot_s as $bobot) {
            $sum += $bobot["bobot_s"];
        }

        foreach ($bobot_s as $bobot) {
            $normalisasi_v[] = [
                'nama' => $bobot['nama'],
                'bobot_v' => round(($bobot["bobot_s"] / $sum), 3)
            ];
        }


        return $normalisasi_v;
    }

    private function ranking_v($bobot_v)
    {

        for ($i = 0; $i < count($bobot_v) - 1; $i++) {

            for ($j = 0; $j < count($bobot_v) - 1; $j++) {

                if ($bobot_v[$j]['bobot_v'] < $bobot_v[$j + 1]['bobot_v']) {
                    $temp = $bobot_v[$j];
                    $bobot_v[$j] = $bobot_v[$j + 1];
                    $bobot_v[$j + 1] = $temp;
                    unset($temp);
                }
            }
        }
        return $bobot_v;
    }
}
