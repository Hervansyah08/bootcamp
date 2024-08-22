<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $dates = ['created_at', 'updated_at'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Jakarta');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Jakarta');
    }

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
