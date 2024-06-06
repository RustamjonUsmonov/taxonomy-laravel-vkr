<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaxonomyRelation extends Model
{
    use HasFactory;

    protected $table = 'taxonomies_relations';
    public $timestamps = false;

    protected $fillable = [
        'similarity',
        'word_1_id',
        'word_2_id'
    ];

    public function first()
    {
        return $this->belongsToMany(TaxonomyElement::class, 'taxonomies_relations',
            'id', 'word_1_id');
    }

    public function second()
    {
        return $this->belongsToMany(TaxonomyElement::class, 'taxonomies_relations',
            'id', 'word_2_id');
    }
}
