<?php

namespace Teamnovu\StatamicUnusedAssets\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Teamnovu\StatamicUnusedAssets\UnusedAssets;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class UpdateUnusedAssetsCacheJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;

    public function handle()
    {
        $unusedAssets = new UnusedAssets();
        $unusedAssets->clearCache();
        $unusedAssets->preloadCache();
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware()
    {
        return [(new WithoutOverlapping())->releaseAfter(60)->expireAfter(180)];
    }

}
