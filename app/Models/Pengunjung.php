<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $fillable = [
        'nama_pengunjung',
        'email',
        'password',
        'foto_profile',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = "pengunjung";
    protected $primaryKey = "id_pengunjung";

    // Relasi atau hubungan lainnya
    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_comment');
    }
}