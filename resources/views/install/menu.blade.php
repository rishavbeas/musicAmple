@php
    $menu = [
        [
            'icon' => 'home',
            'route' => 'install',
        ],
        [
            'icon' => 'checklist',
            'route' => 'install.requirements',
        ],
        [
            'icon' => 'folder-open',
            'route' => 'install.permissions',
        ],
        [
            'icon' => 'database',
            'route' => 'install.database',
        ],
        [
            'icon' => 'account-circle',
            'route' => 'install.account',
        ],
        [
            'icon' => 'checkmark',
            'route' => 'install.complete',
        ],
    ];
@endphp

<div class="p-5">
    <div class="w-full py-6">
        <div class="flex items-center">
            <ol class="flex items-center w-full">
                @foreach ($menu as $link)
                    <li
                        class="{{ $loop->last ? '' : 'flex w-full items-center text-green-700 dark:text-green-500 after:w-full after:h-1 after:border-b after:border-green-500 after:border-4 after:inline-block dark:after:border-green-800' }}">
                        @if (Route::currentRouteName() == $link['route'])
                            <span
                                class="flex items-center justify-center w-10 h-10 bg-green-500 rounded-full lg:h-12 lg:w-12 dark:bg-green-700 shrink-0">
                                <a href="{{ route($link['route']) }}" class="btn btn-primary d-flex align-items-center">
                                    @include('icons.' . $link['icon'], [
                                        'class' => 'w-3.5 h-3.5 text-green-200 lg:w-4 lg:h-4 dark:text-green-300',
                                    ])
                                </a>
                            </span>
                        @else
                            <span
                                class="flex items-center justify-center w-10 h-10 bg-gray-200 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0">
                                <a class="disabled">
                                    @include('icons.' . $link['icon'], [
                                        'class' => 'w-4 h-4 text-gray-500 lg:w-5 lg:h-5 dark:text-gray-100',
                                    ])
                                </a>
                            </span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
