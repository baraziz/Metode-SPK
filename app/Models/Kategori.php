<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['kategori', 'atribut', 'bobot'];

    public function alternatives()
    {
        return $this->belongsToMany(Alternatif::class, 'alternatif_kategori', 'kategori_id', 'alternarif_id')->withPivot('nilai');
    }
}
