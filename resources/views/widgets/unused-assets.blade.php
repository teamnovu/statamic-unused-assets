<div class="card p-0 overflow-hidden h-full">
    <div class="flex justify-between items-center p-4">
        <h2>
            <div class="flex items-center">
                <div class="h-6 w-6 mr-1 text-gray-800">
                    @cp_svg('icons/light/assets')
                </div>
                <span>{{ __('statamic-unused-assets::unused-assets.title') }}</span>
            </div>
        </h2>
    </div>
    <div class="content px-4 pb-2">
        <p>
            {{ __('statamic-unused-assets::unused-assets.explanation') }}
        </p>
        <p class="font-bold">
            {{ trans_choice('statamic-unused-assets::unused-assets.count', $amount, ['amount' => $amount]) }}.
        </p>
    </div>

    @if ($assets)
        <table tabindex="0" class="data-table">
            <tbody tabindex="0">
    @endif
    @forelse ($assets as $asset)
        <tr class="sortable-row outline-none" tabindex="0">
            <td>
                <div class="flex items-center w-full">
                    <div class="little-dot mr-2 bg-orange"></div>
                    <a class="w-full flex justify-between space-x-2" href="{{ $asset['edit_url'] }}" aria-label="{{ __('statamic-unused-assets::unused-assets.edit') }}">
                        <span>{{ $asset['title'] }}</span> <span> :{{ $asset['container'] }}</span>
                    </a>
                </div>
            </td>
            <td class="actions-column"></td>
        </tr>
    @empty
        <div class="content p-4">
            <p>{{ __('statamic-unused-assets::unused-assets.done') }}</p>
        </div>
    @endforelse
    @if ($assets)
            </tbody>
        </table>
    @endif
</div>
