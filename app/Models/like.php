<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'likes';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'question_id'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}