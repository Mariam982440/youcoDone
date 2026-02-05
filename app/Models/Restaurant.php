<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use SoftDeletes;
    protected $fillable = ['owner_id', 'name', 'city', 'cuisine_type',
     'capacity', 'opening_hours', 'description'];
    protected $casts = [
        'opening_hours' => 'array', // conversion automatique JSON <-> Array
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);

    }
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}