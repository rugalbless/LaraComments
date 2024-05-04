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
        $validated = $request->validate([
            'message' => 'required|max:255|string',
        ], [
            'message.required'=>'O campo de comentários é obrigatorio',
            'message.string'=>'O campo de comentários deve conter um texto válido',
            'message.255'=>'O campo de comentários não pode ter mais que 255 caracteres',
        ]);

        $request->user()->comments()->create($validated);

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
