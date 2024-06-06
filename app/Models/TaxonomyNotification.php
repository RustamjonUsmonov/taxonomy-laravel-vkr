<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxonomyNotification extends Model
{
    use HasFactory;

    protected $table = 'taxonomy_notification';
    protected $fillable = [
        'taxonomy_id'
    ];

    public function taxonomy(): BelongsTo
    {
        return $this->belongsTo(Taxonomy::class);
    }
}
