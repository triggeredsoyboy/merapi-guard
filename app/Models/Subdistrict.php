<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subdistrict extends Model
{
    /** @use HasFactory<\Database\Factories\SubdistrictFactory> */
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'vulnerability' => 'array',
        ];
    }

    /**
     * The prone areas that belong to the subdistrict.
     */
    public function proneAreas(): BelongsToMany
    {
        return $this->belongsToMany(ProneArea::class);
    }
}
