<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('comments.index', [
            'comments' => Comment::with('user')->latest()->get(), //eager loading
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validação
        $validated = $request->validate([
            'message' => 'required|max:255|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação da imagem
        ], [
            'message.required' => 'O campo de comentários é obrigatório',
            'message.string' => 'O campo de comentários deve conter um texto válido',
            'message.max' => 'O campo de comentários não pode ter mais que 255 caracteres',
            'image.image' => 'O arquivo deve ser uma imagem válida',
            'image.mimes' => 'A imagem deve ser dos tipos: jpeg, png, jpg, gif, svg',
            'image.max' => 'A imagem não pode ser maior que 2MB',
        ]);

        // Criar o comentário
        $commentData = [
            'message' => $validated['message'],
        ];

        // Se uma imagem for enviada, processa o upload
        if ($request->hasFile('image')) {
            // Armazenar a imagem no diretório 'comments' em 'public'
            $imagePath = $request->file('image')->store('comments', 'public');
            $commentData['image_path'] = $imagePath; // Armazenar o caminho da imagem
        }

        // Criar o comentário associado ao usuário autenticado
        $request->user()->comments()->create($commentData);

        // Mensagem flash para exibir na dashboard
        session()->flash('comment_message', 'Comentário postado com sucesso!');

        // Redirecionar de volta para a lista de comentários
        return to_route('comments.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'message' => 'required|max:255|string',
        ], [
            'message.required'=>'O campo de comentários é obrigatorio',
            'message.string'=>'O campo de comentários deve conter um texto válido',
            'message.255'=>'O campo de comentários não pode ter mais que 255 caracteres',
        ]);
            $comment->update($validated);

            return to_route('comments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return to_route('comments.index');
    }

    private function authorize(string $string, Comment $comment)
    {
    }
}
