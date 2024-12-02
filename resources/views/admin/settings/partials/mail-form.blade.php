<div>
    <x-input-label for="i-smtp-email" :value="__('STMP Mails')" />
    <x-input-select id="i-smtp-email" name="smtp_email" class="mt-1 block w-full" :options="[0 => __('Off'), 1 => __('On')]" :selected="old('smtp_email', config('settings.smtp_email'))" />
    <x-input-error class="mt-2" :messages="$errors->get('smtp_email')" />
</div>
<div>
    <x-input-label for="i-host" :value="__('Host')" />
    <x-text-input id="i-host" name="smtp_host" type="text" class="mt-1 block w-full" :value="old('smtp_host', config('settings.smtp_host'))" />
    <x-input-error class="mt-2" :messages="$errors->get('smtp_host')" />
</div>
<div>
    <x-input-label for="i-port" :value="__('Port')" />
    <x-text-input id="i-port" name="smtp_port" type="number" class="mt-1 block w-full" :value="old('smtp_port', config('settings.smtp_port'))" />
    <x-input-error class="mt-2" :messages="$errors->get('smtp_port')" />
</div>
<div>
    <x-input-label for="i-encryption" :value="__('Encryption')" />
    <x-input-select id="i-encryption" name="smtp_encryption" class="mt-1 block w-full" :options="['tls' => __('TLS'), 'ssl' => __('SSL')]" :selected="old('smtp_encryption', config('settings.smtp_encryption'))" />
    <x-input-error class="mt-2" :messages="$errors->get('smtp_encryption')" />
</div>
<div>
    <x-input-label for="i-username" :value="__('Username')" />
    <x-text-input id="i-username" name="smtp_username" type="text" class="mt-1 block w-full" :value="old('smtp_username', config('settings.smtp_username'))" />
    <x-input-error class="mt-2" :messages="$errors->get('smtp_username')" />
</div>
<div>
    <x-input-label for="i-password" :value="__('Password')" />
    <x-text-input id="i-password" name="smtp_password" type="password" class="mt-1 block w-full" :value="old('smtp_password', config('settings.smtp_password'))" />
    <x-input-error class="mt-2" :messages="$errors->get('smtp_password')" />
</div>
