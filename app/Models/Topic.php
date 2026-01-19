<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function booted()
    {
        static::creating(function ($topic) {
            if (empty($topic->slug) && !empty($topic->name)) {
                $topic->slug = Str::slug($topic->name);
            }
        });
    }

    /**
     * Relasi ke Materi/Video (PENTING: Biar tidak error lagi)
     */
    public function materials()
    {
        return $this->hasMany(\App\Models\Material::class);
    }

    /**
     * Questions under this topic.
     */
    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }
}