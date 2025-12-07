<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'summary',
        'content',
        'category',
        'thumbnail_url',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the thumbnail URL attribute.
     */
    public function getThumbnailAttribute()
    {
        if ($this->thumbnail_url && !str_starts_with($this->thumbnail_url, 'http')) {
            return asset('storage/' . $this->thumbnail_url);
        }
        return $this->thumbnail_url;
    }
}
