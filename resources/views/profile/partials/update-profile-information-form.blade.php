<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    <!-- Flex container to align name/email and profile photo -->
    <div class="flex flex-col md:flex-row items-center gap-6 justify-between"> <!-- flex-col para telas pequenas e flex-row para telas médias e grandes -->

        <!-- Profile Photo -->
        <div class="flex-shrink-0 border-2 border-gray-200 rounded-full shadow-2xl mb-4 md:mb-0"> <!-- Adicionando mb-4 para margens em telas pequenas -->
            @if($user->profile_photo_path)
                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" class="rounded-full w-40 h-40 object-cover">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="Profile Photo" class="rounded-full w-40 h-40 object-cover">
            @endif
        </div>

        <!-- Inputs (Nome e Email) -->
        <div class="flex-1">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button class="w-full flex items-center justify-center text-center">{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >{{ __('Saved.') }}</p>
        @endif
    </div>
</form>
