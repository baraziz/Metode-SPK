<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'jenisKelamin', 'alamat'];

    public function kategories()
    {
        return $this->belongsToMany(Kategori::class, 'alternatif_kategori', 'alternatif_id', 'kategori_id')
            ->withPivot('nilai');
    }
}
