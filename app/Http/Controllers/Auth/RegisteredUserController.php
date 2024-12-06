<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'max:2048'],  // Validação da foto
        ]);

        // Processar a imagem, se fornecida
        $photoPath = null;
        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
            // Salvar a imagem no diretório 'profile_photos' dentro de 'storage/app/public'
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // Criar o usuário com a foto de perfil
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_photo_path' => $photoPath,  // Armazena o caminho no banco de dados
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('comments.index'));
    }

}
