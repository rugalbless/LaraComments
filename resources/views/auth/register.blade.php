<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Pré-visualização da Foto -->
        <div id="image-preview" class="mt-4">
            <img id="preview" src="#" alt="Profile Photo Preview" style="display: none; width: 150px; height: 150px; object-fit: cover; border-radius: 50%;" />
        </div>

        <!-- Foto de Perfil -->
        <div class="mt-4">
            <x-input-label for="profile_photo" :value="__('Profile Photo')" />
            <!-- Atributo onchange para chamar a função previewImage -->
            <x-text-input id="profile_photo" class="block mt-1 w-full" type="file" name="profile_photo" accept="image/*" onchange="previewImage(event)" />
            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
        </div>

        <!-- Nome -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        var preview = document.getElementById('preview');

        reader.onload = function() {
            preview.src = reader.result;  // Definindo a imagem carregada no src
            preview.style.display = 'block'; // Exibindo a imagem
        }

        if (event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);  // Lê o arquivo de imagem selecionado
        }
    }
</script>
