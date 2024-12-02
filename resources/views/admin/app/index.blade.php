@section('site_title', formatTitle([__('App'), config('app.name')]))
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
<x-app-layout>
    <section>
        <x-slot name="header">
            <div class="flex mb-4">
                <div class="w-1/2">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ formatTitle([__('HomePage'), __('Widget')]) }}
                    </h2>
                </div>
                <div class="w-1/2 text-right">
                    <a href="{{ route('app.new') }}"
                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">New</a>
                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
                        <section class="space-y-6" x-data="{ openTab: 1, activeClasses: 'border-l border-t border-r rounded-t text-blue-700', inactiveClasses: 'text-blue-500 hover:text-blue-700' }">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Homepage') }}
                                </h2>
                                @if (session('success'))
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ request()->session()->get('success') }}</p>
                                @endif
                            </header>
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700"
                                x-data="app" x-sortable="{ handle: '.handle'}">
                                <template x-for="widget in widgets">
                                    <li class="handle py-3 sm:py-4" x-bind:data-id="widget.id">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                @include('icons.menu', [
                                                    'class' => 'w-5 h-5',
                                                ])
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                                    x-text="`${widget.title}`"></p>
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                                    x-text="`${widget.type} • ${widget.value ? 'custom' : 'all' }`"></p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                <div class="flex items-center">
                                                    <div class="h-2.5 w-2.5 rounded-full mr-4"
                                                        :class="`${widget.public == 2 ? 'bg-red-500' : 'bg-green-500'}`">
                                                    </div>
                                                    <span
                                                        x-text="`${widget.public == 2 ? 'Unpublic' : 'Public'}`"></span>
                                                </div>
                                                <x-dropdown align="right" width="48">
                                                    <x-slot name="trigger">
                                                        <button
                                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                            @include('icons.vertical', [
                                                                'class' => 'w-5 h-5',
                                                            ])
                                                        </button>

                                                    </x-slot>

                                                    <x-slot name="content">
                                                        <x-dropdown-link
                                                            x-bind:href="'{{ url('admin/app') }}' + '/' + `${widget.id}` + '/edit'"
                                                            class="flex">
                                                            @include('icons.edit', [
                                                                'class' => 'w-5 h-5',
                                                            ])
                                                            <span class="mx-1">
                                                                {{ __('Edit') }}
                                                            </span>
                                                        </x-dropdown-link>
                                                        <hr class="border-gray-200 dark:border-gray-600">
                                                        <x-dropdown-link href="#" class="flex"
                                                            x-on:click.prevent="$dispatch('open-modal', { name: 'modal-action', url: widget.public == 1 ? '{{ url('admin/app') }}' +'/'+ widget.id + '/unpublic' : '{{ url('admin/app') }}' +'/'+ widget.id + '/public', title : widget.public == 2 ? 'Public' : 'Unpublic', subTitle: widget.public == 2 ? 'Are you sure you want to public ' + widget.title + ' ?' : 'Are you sure you want to unpublic ' + widget.title + ' ?' , action: widget.public == 2 ? 'Public' : 'Unpublic' })">
                                                            <template x-if="widget.public === 1">
                                                                @include('icons.suspended', [
                                                                    'class' => 'w-5 h-5 stroke-red-500',
                                                                ])
                                                            </template>
                                                            <template x-if="widget.public !== 1">
                                                                @include('icons.eye', [
                                                                    'class' => 'w-5 h-5 stroke-green-500',
                                                                ])
                                                            </template>
                                                            <span class="mx-1"
                                                                :class="`${widget.public == 2 ? 'text-green-500' : 'text-red-500'}`"
                                                                x-text="`${widget.public == 2 ? 'Public' : 'Unpublic'}`"></span>
                                                        </x-dropdown-link>
                                                        <x-dropdown-link href="#" class="flex"
                                                            x-on:click.prevent="$dispatch('open-modal', { name: 'modal-action', url: '{{ url('admin/app') }}' +'/'+ widget.id + '/destroy' , title: '{{ __('Delete') }}' , subTitle : 'Are you sure you want to delete ' + `${widget.title}` + '?', action: '{{ __('Delete') }}' })">
                                                            @include('icons.delete', [
                                                                'class' => 'w-5 h-5 stroke-red-500',
                                                            ])
                                                            <span class="mx-1 text-red-500">
                                                                {{ __('Delete') }}
                                                            </span>
                                                        </x-dropdown-link>
                                                    </x-slot>
                                                </x-dropdown>
                                            </div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal Action  -->
    <x-modal-action name="modal-action">
        <form method="post" x-bind:action="url" class="p-6">
            @csrf
            @method('post')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" x-text="title"></h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" x-text="subTitle"></p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" x-text="action"></x-danger-button>
            </div>
        </form>
    </x-modal-action>
</x-app-layout>
<script>
    function updateToDatabase(idString) {
        axios.post('{{ url('/admin/app/update-order') }}', {
                ids: idString

            }).then((res) => {

                console.log(res.data);
            })
            .catch((err) => {
                console.log(err);
            });
    }

    window.addEventListener('alpine:init', () => {
        Alpine.directive('sortable', (el, {
            expression
        }, {
            evaluate
        }) => {
            let options = evaluate(expression)
            Sortable.create(el, {
                ...options,
                animation: 150,
                ghostClass: 'opacity-20',
                dragClass: 'bg-gray-400',
                onEnd() {
                    const sorted = [];
                    el.childNodes.forEach(node => {
                        if (node.dataset && node.dataset.id) {
                            sorted.push(node.dataset.id);
                        }
                    });
                    updateToDatabase(sorted)

                }
            });
        });

        Alpine.data('app', () => ({
            widgets: {!! $widgets_sort !!}
        }))
    });
</script>
