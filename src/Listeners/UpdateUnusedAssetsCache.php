<?php

namespace Teamnovu\StatamicUnusedAssets\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Statamic\Events\AssetDeleted;
use Statamic\Events\AssetSaved;
use Statamic\Events\AssetUploaded;
use Statamic\Events\EntryDeleted;
use Statamic\Events\EntrySaved;
use Statamic\Events\GlobalSetDeleted;
use Statamic\Events\GlobalSetSaved;
use Statamic\Events\TermDeleted;
use Statamic\Events\TermSaved;

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

        public function handle($event)
        {
            $this->service->clearCache();
            $this->service->preloadCache();
        }

        /**
         * Register the listeners for the subscriber.
         *
         * @param \Illuminate\Events\Dispatcher $events
         * @return void
         */
        public function subscribe($events)
        {
            $events->listen(AssetDeleted::class, self::class.'@handle');
            $events->listen(AssetSaved::class, self::class.'@handle');
            $events->listen(AssetUploaded::class, self::class.'@handle');
            $events->listen(EntrySaved::class, self::class.'@handle');
            $events->listen(EntryDeleted::class, self::class.'@handle');
            $events->listen(GlobalSetSaved::class, self::class.'@handle');
            $events->listen(GlobalSetDeleted::class, self::class.'@handle');
            $events->listen(TermSaved::class, self::class.'@handle');
            $events->listen(TermDeleted::class, self::class.'@handle');
        }
}
