<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxonomyObject extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    protected $table = 'taxonomy_object';

    protected $fillable = [
        'id',
        'name'
    ];

    public function elements(): HasMany
    {
        return $this->hasMany(TaxonomyElement::class);
    }
}
