<div class="py-2">
    <x-input-label for="i-download" :value="__('Allow downloads')" />
    <x-input-select id="i-download" name="download" x-model="formData.download" class="mt-1 block w-full" :options="[0 => __('Off'), 1 => __('On')]" />
    <x-input-error class="mt-2" :messages="$errors->get('download')" />
</div>
<div class="py-2">
    <x-input-label for="i-status" :value="__('Status')" />
    <x-input-select id="i-status" name="public" x-model="formData.public" class="mt-1 block w-full" :options="[0 => __('Unpublic'), 1 => __('Public')]"/>
    <x-input-error class="mt-2" :messages="$errors->get('public')" />
</div>
