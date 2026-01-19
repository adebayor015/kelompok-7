<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function booted()
    {
        static::creating(function ($topic) {
            if (empty($topic->slug) && !empty($topic->name)) {
                $topic->slug = \Illuminate\Support\Str::slug($topic->name);
            }
        });
    }

    /**
     * Questions under this topic.
     */
    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }
}

