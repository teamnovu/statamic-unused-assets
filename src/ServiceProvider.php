<?php

namespace Teamnovu\StatamicUnusedAssets;

use Statamic\Events\AssetDeleted;
use Statamic\Events\AssetSaved;
use Statamic\Events\AssetUploaded;
use Statamic\Events\EntryDeleted;
use Statamic\Events\EntrySaved;
use Statamic\Events\GlobalSetDeleted;
use Statamic\Events\GlobalSetSaved;
use Statamic\Events\TermDeleted;
use Statamic\Events\TermSaved;
use Statamic\Providers\AddonServiceProvider;
use Teamnovu\StatamicUnusedAssets\Listeners\UpdateUnusedImagesCache;

class ServiceProvider extends AddonServiceProvider
{
    protected $listen = [
        AssetDeleted::class => [
            UpdateUnusedImagesCache::class,
        ],
        AssetSaved::class => [
            UpdateUnusedImagesCache::class,
        ],
        AssetUploaded::class => [
            UpdateUnusedImagesCache::class,
        ],
        EntrySaved::class => [
            UpdateUnusedImagesCache::class,
        ],
        EntryDeleted::class => [
            UpdateUnusedImagesCache::class,
        ],
        GlobalSetSaved::class => [
            UpdateUnusedImagesCache::class,
        ],
        GlobalSetDeleted::class => [
            UpdateUnusedImagesCache::class,
        ],
        TermSaved::class => [
            UpdateUnusedImagesCache::class,
        ],
        TermDeleted::class => [
            UpdateUnusedImagesCache::class,
        ],
    ];

    protected $widgets = [
        \Teamnovu\StatamicUnusedAssets\Widgets\Widget::class,
    ];

    public function bootAddon()
    {
        //
    }
}
