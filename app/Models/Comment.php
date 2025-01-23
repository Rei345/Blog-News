<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'commentable_id', 'commentable_type', 'id_berita'];

    protected $table = "comments";

    protected $primaryKey = "id";

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'id_berita');
    }

    // Relasi dengan Pengunjung
    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class, 'commentable_id'); // Ganti sesuai dengan kolom relasi yang benar
    }
}
