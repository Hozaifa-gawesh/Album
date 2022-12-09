<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'albums';

    protected $fillable = [
        'name',
        'status',
    ];

    protected $dates = ['deleted_at'];

    protected $appends = [
        'status_name',
    ];

    const STATUS_ALBUM = [
        0 => 'unpublished',
        1 => 'published',
    ];

    // Accessors & Mutators
    public function getStatusKeyAttribute()
    {
        return Self::STATUS_ALBUM[$this->status];
    }

    public function getStatusNameAttribute()
    {
        return __('status.' . $this->getStatusKeyAttribute());
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', true);
    }

    public function scopeUnpublished($query)
    {
        return $query->where('status', false);
    }


    // Relations Functions
    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class);
    }

}
