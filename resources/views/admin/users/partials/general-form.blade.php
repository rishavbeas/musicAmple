<div>
    <x-input-label for="i-username" :value="__('Username')" />
    <x-text-input id="i-username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required
        autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('username')" />
</div>

<div>
    <x-input-label for="i-first-name" :value="__('First Name')" />
    <x-text-input id="i-first-name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)"
        autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
</div>

<div>
    <x-input-label for="i-last-name" :value="__('Last Name')" />
    <x-text-input id="i-last-name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)"
        autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
</div>

<div>
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
    <x-input-error class="mt-2" :messages="$errors->get('email')" />
</div>

<div>
    <x-input-label for="i-country" :value="__('Country')" />
    <x-text-input id="i-country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('Country')" />
</div>

<div>
    <x-input-label for="i-city" :value="__('City')" />
    <x-text-input id="i-city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('city')" />
</div>

<div>
    <x-input-label for="i-website" :value="__('Website')" />
    <x-text-input id="i-website" name="website" type="text" class="mt-1 block w-full" :value="old('website', $user->website)" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('website')" />
</div>

<div>
    <x-input-label for="i-role" :value="__('Role')" />
    <x-input-select id="i-role" name="role" class="mt-1 block w-full" :options="['User', 'Admin']" :selected="old('role', $user->role)" autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('role')" />
</div>

<hr class="border-gray-200 dark:border-gray-700">
<div>
    <x-input-label for="i-description" :value="__('Description')" />
    <x-text-area id="i-description" name="description" class="mt-1 block w-full" :value="old('description', $user->description)"
        autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>
