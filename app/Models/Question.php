<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'topic_id',
        'title',
        'content',
        'attachment'
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RELASI KE TOPIK
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    // RELASI KE JAWABAN
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}