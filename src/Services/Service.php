<?php

namespace Teamnovu\StatamicUnusedAssets\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Statamic\Assets\AssetCollection;
use Statamic\Facades\Asset;

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

    public function getUnusedAssets(): array
    {
        return Cache::rememberForever(
            $this->getCacheKey(),
            function () {
                return $this->filterUnused(Asset::all());
            }
        );
    }

    private function filterUnused(AssetCollection $assets): array
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
                'edit_url' => $asset->editUrl(),
            ];
        })->all();
    }

    public function preloadCache(): void
    {
        $this->getUnusedAssets();
    }
}
