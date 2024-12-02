<section class="space-y-6">
    <header>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="flex p-4 mb-4 text-green-800 rounded-lg border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-00"
                role="alert">
                @include('icons.check-circle', ['class' => 'flex-shrink-0 w-5 h-5'])
                <div class="ml-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                role="alert">
                @include('icons.information-circle', ['class' => 'flex-shrink-0 w-5 h-5'])
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile') }}
        </h2>
    </header>
    <form enctype="multipart/form-data" method="post" action="{{ route('artists.profile', $artist->id) }}"
        class="mt-6 space-y-6">
        @csrf
        <div class="flex items-center space-x-4" x-data="previewImage()">
            <div class="flex-shrink-0">
                <label for="imageUpload">
                    <img class="w-24 h-24 rounded-lg object-cover" x-show="imageUrl" :src="imageUrl"
                        alt="{{ $artist->name }}">
                </label>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-md font-bold text-gray-900 truncate dark:text-white">
                    {{ $artist->name }}
                </p>
                <button type="button" :class="selectedImage ? 'bg-green-300 text-green-800' : 'bg-white'"
                    class="w-36 inline-flex items-center px-4 py-2 mt-6 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
                    @click="$refs.image.click()"
                    x-text="selectedImage ? '{{ __('Image Selected') }}' : '{{ __('Change Image') }}'"></button>
                <x-input-file accept="image/*" class="hidden" id="imageUpload" name="image" x-ref="image" x-on:change="fileChosen" />
            </div>
        </div>
        <hr class="border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>

<script>
    function previewImage() {
        return {
            imageUrl: '',
            selectedImage: false,
            fileChosen(event) {
                this.fileToDataUrl(event, (src) => (this.imageUrl = src));
            },
            init() {
                this.imageUrl = "{{ url('/') }}/uploads/avatars/{{ $artist->image }}",
                this.selectedImage = false
            },
            fileToDataUrl(event, callback) {
                if (!event.target.files.length) return;

                let file = event.target.files[0],
                    reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload = (e) => callback(e.target.result);
            },
        };
    }
</script>
