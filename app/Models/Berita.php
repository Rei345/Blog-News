<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    protected $table = "berita";

    protected $primaryKey = "id_berita";

    protected $fillable = ["judul_berita", "isi_berita", "gambar_berita", "id_kategori", "total_views", "slug"];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Mutator untuk membuat slug dari judul_berita
    public function setJudulBeritaAttribute($value)
    {
        $this->attributes['judul_berita'] = $value;
        $this->attributes['slug'] = Str::slug($value, '-');
    }
}