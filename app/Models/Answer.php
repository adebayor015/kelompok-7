<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI:
    // Ini daftar kolom yang boleh diisi lewat form/input
    protected $fillable = [
        'question_id', 
        'user_id', 
        'content'
    ];

    // Relasi ke User (Biar bisa manggil $answer->user->name)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
