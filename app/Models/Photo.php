<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Photo extends Model
{
    protected $fillable = [
        'project_id',
        'uuid',
        'url',
        'latitude',
        'longitude',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function movements(): BelongsToMany
    {
        return $this->belongsToMany(Photo::class, 'movements', 'photo_id', 'next_photo_id')
            ->withPivot(['angle']);
    }
}
