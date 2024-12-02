@section('site_title', formatTitle([__('Report'), config('app.name')]))
<x-app-layout>
    <section>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Report') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
                        <div class="max-w-xl">
                            <section class="space-y-6" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ $x }}
                                    </h2>
                                </header>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ url('/') }}/uploads/avatars/{{ $report->users->image }}"
                                            alt="{{ realname($report->users->username, $report->users->first_name, $report->users->last_name) }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ realname($report->users->username, $report->users->first_name, $report->users->last_name) }}
                                        </p>
                                    </div>
                                </div>
                                <hr class="border-gray-200 dark:border-gray-700">
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ $title }}
                                    </h2>
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $report->content }}
                                    </p>
                                </div>
                                <div>
                                    @php
                                        if ($report->state != 2) {
                                            $artist_detail = App\Http\Controllers\TracksController::getArtistDetail($track->artist_id);
                                        }
                                    @endphp
                                    @if ($report->state != 2)
                                        <hr class="border-gray-200 dark:border-gray-700">
                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ $y }}
                                        </h2>
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <a href="{{ route('tracks.show', ['id' => $track->id, 'filter' => 'today']) }}"
                                                    title="{{ $track->title }}"><img
                                                        class="w-8 h-8 rounded-lg object-cover"
                                                        src="{{ trackCover($track->art, $track->albums->image, $artist_detail['image'][0]) }}"></a>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    <a href="{{ route('tracks.show', ['id' => $track->id, 'filter' => 'today']) }}"
                                                        title="{{ $track->title }}">{{ $track->title }}</a>
                                                </p>
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    {{ implode(',', $artist_detail['name']) }}
                                                </p>
                                            </div>
                                        </div>
                                </div>
                                @endif
                                <hr class="border-gray-200 dark:border-gray-700">
                                @if ($report->state == 0)
                                    <div>
                                        <a href="{{ route('reports.suspend', $report->id) }}">
                                            <x-normal-button :value="__('Suspend Track')" />
                                        </a>
                                        <a href="{{ route('reports.delete.track', $report->id) }}">
                                            <x-normal-button :value="__('Delete Track')" />
                                        </a>
                                        <a href="{{ route('reports.delete', $report->id) }}">
                                            <x-normal-button :value="__('Delete Report')" />
                                        </a>
                                    </div>
                                @elseif ($report->state == 1)
                                    <div class="flex p-4 mb-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
                                        role="alert">
                                        @include('icons.check-circle', [
                                            'class' => 'flex-shrink-0 w-5 h-5',
                                        ])
                                        <div class="ml-3 text-sm font-medium">
                                            {{ __('The report has been marked as safe.') }}</div>
                                    </div>
                                @elseif ($report->state == 2)
                                    @if ($report->type == 0)
                                        <div class="flex mt-4 p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                            role="alert">
                                            @include('icons.check-circle', [
                                                'class' => 'flex-shrink-0 w-5 h-5',
                                            ])
                                            <div class="ml-3 text-sm font-medium">
                                                {{ __('The comment has been deleted.') }}</div>
                                        </div>
                                    @else
                                        <div class="flex mt-4 p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                            role="alert">
                                            @include('icons.check-circle', [
                                                'class' => 'flex-shrink-0 w-5 h-5',
                                            ])
                                            <div class="ml-3 text-sm font-medium">
                                                {{ __('The track has been deleted.') }}</div>
                                        </div>
                                    @endif
                                @elseif ($report->state == 3)
                                    <div class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                        role="alert">
                                        @include('icons.check-circle', [
                                            'class' => 'flex-shrink-0 w-5 h-5',
                                        ])
                                        <div class="ml-3 text-sm font-medium">{{ __('The track has been suspended.') }}
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('reports.restore', $report->id) }}">
                                            <x-normal-button :value="__('Restore Track')" />
                                        </a>
                                    </div>
                                @elseif ($report->state == 4)
                                    <div class="flex p-4 mb-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
                                        role="alert">
                                        @include('icons.check-circle', [
                                            'class' => 'flex-shrink-0 w-5 h-5',
                                        ])
                                        <div class="ml-3 text-sm font-medium">{{ __('The track has been restored.') }}
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('reports.suspend', $report->id) }}">
                                            <x-normal-button :value="__('Suspend Track')" />
                                        </a>
                                        <a href="{{ route('reports.delete.track', $report->id) }}">
                                            <x-normal-button :value="__('Delete Track')" />
                                        </a>
                                        <a href="{{ route('reports.delete', $report->id) }}">
                                            <x-normal-button :value="__('Delete Report')" />
                                        </a>
                                    </div>
                                @endif
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
