<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';

    protected $fillable = [
        'user_id',
        'nama',
        'deskripsi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function master()
    {
        return $this->hasMany(Master::class);
    }
    public function materi()
    {
        return $this->hasMany(Materi::class);
    }
    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class);
    }
}
