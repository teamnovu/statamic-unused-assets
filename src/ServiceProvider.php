<?php

namespace Teamnovu\StatamicUnusedAssets;

use Statamic\Providers\AddonServiceProvider;
use Teamnovu\StatamicUnusedAssets\Listeners\UpdateUnusedAssetsCache;
use Teamnovu\StatamicUnusedAssets\Widgets\Widget;

class ServiceProvider extends AddonServiceProvider
{
    protected $subscribe = [
        UpdateUnusedAssetsCache::class,
    ];

    protected $widgets = [
        Widget::class,
    ];

    public function bootAddon()
    {
        //
    }
}
