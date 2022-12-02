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
use Teamnovu\StatamicUnusedAssets\Listeners\UpdateUnusedAssetsCache;

class ServiceProvider extends AddonServiceProvider
{
    protected $listen = [
        AssetDeleted::class => [
            UpdateUnusedAssetsCache::class,
        ],
        AssetSaved::class => [
            UpdateUnusedAssetsCache::class,
        ],
        AssetUploaded::class => [
            UpdateUnusedAssetsCache::class,
        ],
        EntrySaved::class => [
            UpdateUnusedAssetsCache::class,
        ],
        EntryDeleted::class => [
            UpdateUnusedAssetsCache::class,
        ],
        GlobalSetSaved::class => [
            UpdateUnusedAssetsCache::class,
        ],
        GlobalSetDeleted::class => [
            UpdateUnusedAssetsCache::class,
        ],
        TermSaved::class => [
            UpdateUnusedAssetsCache::class,
        ],
        TermDeleted::class => [
            UpdateUnusedAssetsCache::class,
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
