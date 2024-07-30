<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumpulan extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan';

    protected $fillable = [
        'user_id',
        'program_id',
        'tugas_id',
        'judul',
        'deskripsi',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
