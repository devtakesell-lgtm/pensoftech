<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Str;

class PageService
{
    public function storePage(array $validated): Page
    {
        $validated['slug'] = Str::slug($validated['title']);
        $page = Page::create($validated);

        $this->syncSeo($page, $validated);

        return $page;
    }

    public function updatePage(Page $page, array $validated): Page
    {
        $validated['slug'] = Str::slug($validated['title']);
        $page->update($validated);

        $this->syncSeo($page, $validated);

        return $page;
    }

    private function syncSeo(Page $page, array $validated): void
    {
        $page->seo()->updateOrCreate(
            ['seoable_id' => $page->id, 'seoable_type' => Page::class],
            [
                'meta_title' => $validated['meta_title'] ?? $validated['title'],
                'meta_description' => $validated['meta_description'] ?? null,
                'meta_keywords' => $validated['meta_keywords'] ?? null,
            ]
        );
    }
}
