# Statamic Unused Assets

> This is an addon to list all assets that are not used in your statamic site.

## Features

This addon adds a widget which you can add to your dashboard. If there are assets which are currently not in use on your sites they will be listed in that widget.

## How to Install

You can run the following command from your project root:

``` bash
composer require teamnovu/statamic-unused-assets
```

## How to Use

Just add the widget to your `config/statamic/cp.php` as you would [any other widget](https://statamic.dev/widgets#configuration).

The following is an example which shows all the possible config values you can use.

```php
'widgets' => [
    // ...

    [
        'type' => 'unused-assets', // Required
        'limit' => 10, // Default: 5 – The number of images to display in the widget.
        'width' => 100, // Default: 100 – The size of the widget.
    ],
],
```

> **Note**
>This widget caches the assets displayed forever and
> updates the cache when events such as
> AssetDeleted, AssetSaved  AssetUploaded
> EntryDeleted, EntrySaved
> TermDeleted, TermSaved
> GlobalSetDeleted, GlobalSetSaved
> are fired.

## Credit

This widget has basically been extracted from the [Statamic Peak starter kit](https://github.com/studio1902/statamic-peak) and
merged with [swiftmade/statamic-clear-assets](https://github.com/swiftmade/statamic-clear-assets)
