<?php

namespace Teamnovu\StatamicUnusedAssets\Widgets;

use Statamic\Widgets\Widget as BaseWidget;

class Widget extends BaseWidget
{
    protected static $handle = 'unused-assets';

    public function __construct(
        protected \Teamnovu\StatamicUnusedAssets\Services\Service $service,
    ) {
    }

    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        $assets = $this->service->getUnusedAssets();

        return view('statamic-unused-assets::widgets.unused-assets', [
            'assets' => array_slice($assets, 0, $this->config('limit', 5)),
            'amount' => count($assets),
        ]);
    }
}
