<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kategori;

class TopsisController extends Controller
{
    public function index()
    {
        try {
            return view('hasil-seleksi.topsis', $this->topsis());
        } catch (\Throwable) {
            return view('hasil-seleksi.error');
        }
    }

    private function topsis()
    {
        $alternatives = Alternatif::all('id', 'nama', 'alamat', 'jenisKelamin')->load('kategories:kategori,atribut,bobot');
        $alternatives->setHidden(['id']);
        $kategories = Kategori::all('id', 'kategori', 'bobot');

        $data = array();
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

        $normalizedMatrix = $this->normalizeMatrix($data, $attributes);
        $weightedMatrix = $this->weightMatrix($normalizedMatrix, $bobotKategori);
        $idealSolutions = $this->calculateIdealSolutions($weightedMatrix);
        $distancePositive = $this->calculateDistance($weightedMatrix, $idealSolutions['positive']);
        $distanceNegative = $this->calculateDistance($weightedMatrix, $idealSolutions['negative']);
        $scores = $this->calculateScores($distancePositive, $distanceNegative);
        $rankings = $this->ranking($scores);

        $alternatives->setHidden(['id', 'kategories', 'alamat', 'jenisKelamin']);
        $num = 0;
        foreach ($alternatives as $alternatif) {
            $alternatif->normalizedMatrix = $normalizedMatrix[$num];
            $alternatif->weightedMatrix = $weightedMatrix[$num];
            $alternatif->distancePositive = $distancePositive[$num];
            $alternatif->distanceNegative = $distanceNegative[$num];
            $alternatif->score = $scores[$num];
            $alternatif->ranking = $rankings[$num];
            $rankings[$num] = [
                'nama' => $alternatif->nama,
                'bobot' => $rankings[$num]
            ];
            $num++;
        }

        return ['alternatives' => $alternatives, 'rankings' => $rankings, 'kategories' => $kategories];
    }

    private function normalizeMatrix($data, $attributes)
    {
        $normalizedMatrix = array();
        $cost = function ($attribute) {
            return $attribute == 'cost';
        };

        for ($i = 0; $i < count($data[0]); $i++) {
            $colData = array_column($data, $i);
            $minValue = min($colData);
            $maxValue = max($colData);

            for ($j = 0; $j < count($data); $j++) {
                if ($cost($attributes[$i])) {
                    $normalizedMatrix[$j][$i] = round($minValue / $data[$j][$i], 3);
                } else {
                    $normalizedMatrix[$j][$i] = round($data[$j][$i] / $maxValue, 3);
                }
            }
        }

        return $normalizedMatrix;
    }

    private function weightMatrix($normalizedMatrix, $kategories)
    {
        $weightedMatrix = array();

        for ($i = 0; $i < count($normalizedMatrix); $i++) {
            for ($j = 0; $j < count($normalizedMatrix[0]); $j++) {
                $weightedMatrix[$i][$j] = round($normalizedMatrix[$i][$j] * $kategories[$j], 2);
            }
        }

        return $weightedMatrix;
    }

    private function calculateIdealSolutions($weightedMatrix)
    {
        $idealSolutions = array(
            'positive' => array(),
            'negative' => array()
        );

        for ($i = 0; $i < count($weightedMatrix[0]); $i++) {
            $colData = array_column($weightedMatrix, $i);
            $idealSolutions['positive'][$i] = max($colData);
            $idealSolutions['negative'][$i] = min($colData);
        }

        return $idealSolutions;
    }

    private function calculateDistance($weightedMatrix, $idealSolution)
    {
        $distance = array();

        for ($i = 0; $i < count($weightedMatrix); $i++) {
            $sum = 0;

            for ($j = 0; $j < count($weightedMatrix[0]); $j++) {
                $sum += pow($weightedMatrix[$i][$j] - $idealSolution[$j], 2);
            }

            $distance[$i] = round(sqrt($sum), 2);
        }

        return $distance;
    }

    private function calculateScores($distancePositive, $distanceNegative)
    {
        $scores = array();

        for ($i = 0; $i < count($distancePositive); $i++) {
            $scores[$i] = round($distanceNegative[$i] / ($distancePositive[$i] + $distanceNegative[$i]), 2);
        }

        return $scores;
    }

    private function ranking($alternatives)
    {
        for ($i = 0; $i < count($alternatives) - 1; $i++) {
            for ($j = 0; $j < count($alternatives) - 1; $j++) {
                if ($alternatives[$j] < $alternatives[$j + 1]) {
                    $temp = $alternatives[$j];
                    $alternatives[$j] = $alternatives[$j + 1];
                    $alternatives[$j + 1] = $temp;
                }
            }
        }

        return $alternatives;
    }
}
