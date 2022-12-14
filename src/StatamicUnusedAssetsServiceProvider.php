<?php

namespace Teamnovu\StatamicUnusedAssets;

use Statamic\Providers\AddonServiceProvider;
use Teamnovu\StatamicUnusedAssets\Listeners\UpdateUnusedAssetsCacheListener;
use Teamnovu\StatamicUnusedAssets\Widgets\Widget;

class StatamicUnusedAssetsServiceProvider extends AddonServiceProvider
{
    protected $subscribe = [
        UpdateUnusedAssetsCacheListener::class,
    ];

    protected $widgets = [
        Widget::class,
    ];

    public function bootAddon()
    {
        //
    }
}
