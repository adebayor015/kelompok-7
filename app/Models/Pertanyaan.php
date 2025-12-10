<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaans'; // ⬅ jika nama tabel pakai plural
    // atau jika di DB nama tabel = "pertanyaan", ubah jadi:
    // protected $table = 'pertanyaan';

    protected $fillable = ['name',
                        'question',
                        'answers'];
} 