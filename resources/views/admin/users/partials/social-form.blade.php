

<div>
    <x-input-label for="i-facebook" :value="__('Facebook')" />
    <x-text-input id="i-facebook" name="facebook" type="text" class="mt-1 block w-full" :value="old('facebook', $user->facebook)"
        autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('facebook')" />
</div>

<div>
    <x-input-label for="i-twitter" :value="__('Twitter')" />
    <x-text-input id="i-twitter" name="twitter" type="text" class="mt-1 block w-full" :value="old('twitter', $user->twitter)"
        autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
</div>

<div>
    <x-input-label for="i-instagram" :value="__('Instagram')" />
    <x-text-input id="i-instagram" name="instagram" type="text" class="mt-1 block w-full"
        :value="old('instagram', $user->instagram)" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('instagram')" />
</div>

<div>
    <x-input-label for="i-youtube" :value="__('Youtube')" />
    <x-text-input id="i-youtube" name="youtube" type="text" class="mt-1 block w-full" :value="old('youtube', $user->youtube)"
        autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('youtube')" />
</div>

<div>
    <x-input-label for="i-telegram" :value="__('Telegram')" />
    <x-text-input id="i-telegram" name="telegram" type="text" class="mt-1 block w-full" :value="old('telegram', $user->telegram)"
        autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('telegram')" />
</div>
