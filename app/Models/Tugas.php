<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'user_id',
        'program_id',
        'judul',
        'deskripsi',
        'file',
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
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function pengumpulan()
    {
        return $this->hasMany(Pengumpulan::class);
    }
}
