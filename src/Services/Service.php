<?php

namespace Teamnovu\StatamicUnusedAssets\Services;

use Illuminate\Support\Facades\Cache;
use Statamic\Facades\Asset;
use Statamic\Assets\AssetCollection;
use Illuminate\Support\Facades\File;

class Service
{
    public function getCacheKey()
    {
        return "widgets::StatamicUnusedAssets";
    }

    public function clearCache() : void
    {
        Cache::forget($this->getCacheKey());
    }

    public function getUnusedAssets(): Array
    {
        return Cache::rememberForever(
            $this->getCacheKey(),
            function ()  {
                return $this->filterUnused(Asset::all());
            }
        );
    }

    private function filterUnused(AssetCollection $assets): Array
    {
        collect(File::allFiles(base_path('content')))->each(function ($contentFile) use ($assets) {
            $contents = file_get_contents($contentFile);

            $assets->each(function ($asset, $index) use ($contents, $assets) {
                // If asset is used in content, then remove it from unused list.
                if (strpos($contents, $asset->path()) !== false) {
                    $assets->forget($index);
                }
            });
        });

        // assets map certain pops
        $assets->multisort('container:desc|title:desc');

        return $assets->map(function ($asset) {
            return [
                'id' => $asset->id(),
                'title' => $asset->title(),
                'path' => $asset->path(),
                'container' => $asset->container()->handle(),
                'api_url' => $asset->apiUrl(),
            ];
        })->all();

    }

    public function preloadCache(): void
    {
        $this->getUnusedAssets();
    }
}
