<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProneArea extends Model
{
    /** @use HasFactory<\Database\Factories\ProneAreaFactory> */
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The subdistricts that belong to the prone area.
     */
    public function subdistricts(): BelongsToMany
    {
        return $this->belongsToMany(Subdistrict::class, 'prone_area_subdistrict');
    }
}
