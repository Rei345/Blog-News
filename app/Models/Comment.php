<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_berita', 'comment', 'id_pengunjung'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }

    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class, 'id_pengunjung');
    }
}
