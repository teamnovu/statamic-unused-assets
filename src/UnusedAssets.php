<?php

namespace Teamnovu\StatamicUnusedAssets;

use Illuminate\Support\Facades\Cache;
use Statamic\Assets\AssetCollection;
use Statamic\Facades\Asset;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Term;
use Statamic\Facades\Nav;

class UnusedAssets
{
    public function getCacheKey()
    {
        return 'widgets::StatamicUnusedAssets';
    }

    public function clearCache(): void
    {
        Cache::forget($this->getCacheKey());
    }

    public function getUnusedAssets(): AssetCollection
    {
        return Cache::rememberForever(
            $this->getCacheKey(),
            function () {
                return $this->filterUnused(Asset::all());
            }
        );
    }

    private function filterUnused(AssetCollection $assets): AssetCollection
    {
        $contents = Entry::all()
            ->merge(Term::all())
            ->merge(GlobalSet::all())
            ->merge(Nav::all());

        collect($contents)->each(function ($content) use ($assets) {
            if ($content instanceof \Statamic\Entries\Entry) {
                $contentValues = $content->values();
            }

            if ($content instanceof \Statamic\Taxonomies\Term || $content instanceof \Statamic\Taxonomies\LocalizedTerm) {
                $contentValues = $content->values();
            }

            // https://statamic.dev/repositories/global-repository
            if ($content instanceof \Statamic\Globals\GlobalSet) {
                $set = GlobalSet::findByHandle($content->handle());
                $data = $set->inDefaultSite();
                $contentValues = $data->values();
            }

            if ($content instanceof \Statamic\Structures\Nav) {
                $contentValues = collect();

                $nav = Nav::findByHandle($content->handle());
                $data = $nav->trees();

                $data->values()->each(function ($value) use (&$contentValues) {
                    $contentValues = $contentValues->merge($value->tree());
                });
            }

            $contentValues = $contentValues->toJson();

            $assets->each(function ($asset, $index) use ($contentValues, $assets) {
                // If asset is used in content, then remove it from unused list.
                if (strpos($contentValues, json_encode($asset->path())) !== false) {
                    $assets->forget($index);
                }
            });
        });

        $assets->multisort('container:desc|title:desc');

        return $assets->map(function ($asset) {
            return [
                'id' => $asset->id(),
                'title' => $asset->title(),
                'path' => $asset->path(),
                'container' => $asset->container()->handle(),
                'edit_url' => $asset->editUrl(),
            ];
        });
    }

    public function preloadCache(): void
    {
        $this->getUnusedAssets();
    }
}
