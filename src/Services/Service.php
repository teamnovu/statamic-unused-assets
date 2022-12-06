<?php

namespace Teamnovu\StatamicUnusedAssets\Services;

use Illuminate\Support\Facades\Cache;
use Statamic\Assets\AssetCollection;
use Statamic\Facades\Asset;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Term;

class Service
{
    public function getCacheKey()
    {
        return 'widgets::StatamicUnusedAssets';
    }

    public function clearCache(): void
    {
        Cache::forget($this->getCacheKey());
    }

    public function getUnusedAssets($excludedPaths): array
    {

        return $this->filterUnused(Asset::all(), $excludedPaths);
        return Cache::rememberForever(
            $this->getCacheKey(),
            function () use ($excludedPaths) {
                return $this->filterUnused(Asset::all(), $excludedPaths);
            }
        );
    }

    private function filterUnused(AssetCollection $assets, Array $excludedPaths): array
    {

        // remove all excluded assets
        if (is_array($excludedPaths)) {

            $assets->each(function ($asset, $index) use ($excludedPaths, $assets) {

                foreach ($excludedPaths as $path) {
                    if (str_contains($asset->container()->handle().'/'.$asset->path(), $path)) {
                        $assets->forget($index);
                    }
                }
            });
        }

        $contents = Entry::all()
            ->merge(Term::all())
            ->merge(GlobalSet::all());

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
        })->all();
    }

    public function preloadCache(): void
    {
        $this->getUnusedAssets();
    }
}
