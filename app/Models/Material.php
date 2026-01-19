<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials'; // Menegaskan nama tabel

    protected $fillable = [
        'topic_id', 
        'title', 
        'slug', 
        'content', 
        'video_url'
    ];

    protected static function booted()
    {
        static::creating(function ($material) {
            if (empty($material->slug) && !empty($material->title)) {
                $material->slug = Str::slug($material->title);
            }
        });
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}