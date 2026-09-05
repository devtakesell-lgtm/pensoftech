<?php

namespace Database\Factories;

use App\Models\SeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SeoMeta>
 */
class SeoMetaFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            // seoable_type and seoable_id are set by the seeder via morphOne()
            // so we don't define them here
            'meta_title' => $title,
            'meta_description' => fake()->sentences(2, true),
            'meta_keywords' => implode(', ', fake()->words(5)),
            'canonical_url' => null,
            'robots' => 'index, follow',
            'og_title' => $title,
            'og_description' => fake()->sentence(),
            'og_image' => null,
            'schema_json' => null,
        ];
    }
}
