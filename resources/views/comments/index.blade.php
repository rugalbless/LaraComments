
<x-app-layout>
    <div class="sm:max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('comments.store') }}" enctype="multipart/form-data">
            @csrf

            <textarea
                name="message"
                placeholder="O que você está pensando?"
                class="block w-full border-gray-300 focus:border-indigo-300 rounded-md shadow-sm">{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <div class="mt-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Anexar uma foto</label>
                <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <x-primary-button class="mt-4">Comentar</x-primary-button>
        </form>


        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($comments as $comment)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $comment->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $comment->created_at->format('j M Y, g:i a') }}</small>

                                @unless ($comment->created_at->eq($comment->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('Editado') }}</small>
                                @endunless
                            </div>

                            @if ($comment->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('comments.edit',$comment)">
                                            {{ __('Editar') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{  route('comments.destroy', $comment) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href=" route('comments.destroy', $comment)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Excluir') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <!-- Exibição do comentário -->
                        <p class="mt-4 text-lg text-gray-900">{{ $comment->message }}</p>

                        <!-- Verificação se há imagem e exibição -->
                        @if ($comment->image_path)
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $comment->image_path) }}" alt="Imagem do comentário" class="max-w-full rounded-md">
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>


    </div>
</x-app-layout>
