<?php

namespace App\Models;

use Database\Factories\SeoMetaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    /** @use HasFactory<SeoMetaFactory> */
    use HasFactory;

    protected $table = 'seo_metas';

    protected $fillable = [
        'seoable_id',
        'seoable_type',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'robots',
        'og_title',
        'og_description',
        'og_image',
        'schema_json',
    ];

    protected $casts = [
        'schema_json' => 'array',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
