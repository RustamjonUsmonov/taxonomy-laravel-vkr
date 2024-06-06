<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaxonomyElement extends Model
{
    use HasFactory;

    protected $table = 'taxonomies_element';
    protected $fillable = [
        'taxonomy_object_id',
        'element'
    ];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(TaxonomyElement::class)
            ->using(TaxonomyRelation::class)
            ->withPivot(['similarity'])
            ->with('children');
    }

    public function object(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TaxonomyObject::class,'taxonomy_object_id','id','taxonomy_object');
    }
}
