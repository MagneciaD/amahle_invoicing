<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Company Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your Company profile information.") }}
            <span class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                <!-- Company Name -->
                {{ Auth::user()->company ? Auth::user()->company->name : 'No Company' }}

                <!-- Company Logo -->
                <img src="{{ Auth::user()->company ? Auth::user()->company->company_logo : 'No Logo' }}"
                    alt="Logo"
                    style="width: 45px; height: 45px; margin-left: 10px;">
            </span>

        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('company.update') }}" class="mt-6 space-y-6">
    @csrf
        @method('patch')

        <div>
            <x-input-label for="company_name" :value="__('Company Name')" />
            <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full"  :value="old('company_name', Auth::user()->company->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
        </div>
        <div>
            <x-input-label for="address" :value="__('Company Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', Auth::user()->company->address)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="company_details" :value="__('Company Details')" />
            <x-text-input id="company_details" name="company_details" type="text" class="mt-1 block w-full" :value="old('company_details', Auth::user()->company->company_details)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('company_details')" />
        </div>

        <div>
            <x-input-label for="number" :value="__('Number')" />
            <x-text-input id="number" name="number" type="text" class="mt-1 block w-full" :value="old('number', Auth::user()->company->number)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('number')" />
        </div>
        <div>
            <x-input-label for="banking_details" :value="__('Banking Details')" />
            <x-text-input id="banking_details" name="banking_details" type="text" class="mt-1 block w-full" :value="old('banking_details', Auth::user()->company->banking_details)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('number')" />
        </div>

        <div>
            <x-input-label for="company_logo" :value="__('Company Logo')" />
            <x-text-input id="company_logo" name="company_logo" type="text" class="mt-1 block w-full" :value="old('company_logo', Auth::user()->company->company_logo)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('company_Logo')" />
        </div>

        <div>
            <x-input-label for="signature" :value="__('Signature')" />
            <x-text-input id="signature" name="signature" type="text" class="mt-1 block w-full" :value="old('signature', Auth::user()->company->signature)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('signature')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', Auth::user()->company->email)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>