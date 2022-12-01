<?php

namespace Teamnovu\StatamicUnusedAssets\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Statamic\Events\AssetDeleted;
use Statamic\Events\AssetSaved;
use Statamic\Events\AssetUploaded;
use Statamic\Events\EntrySaved;
use Statamic\Events\EntryDeleted;
use Statamic\Events\GlobalSetSaved;
use Statamic\Events\GlobalSetDeleted;
use Statamic\Events\TermSaved;
use Statamic\Events\TermDeleted;


class UpdateUnusedAssetsCache implements ShouldQueue
{
    use Queueable;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        protected \Teamnovu\StatamicUnusedAssets\Services\Service $service,
    ) {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AssetDeleted|AssetSaved|AssetUploaded|EntrySaved|EntryDeleted|GlobalSetSaved|GlobalSetDeleted|TermSaved|TermDeleted $event)
    {
        $this->service->clearCache();
        $this->service->preloadCache();
    }
}
