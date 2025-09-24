<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Сохранение нового комментария
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:500',
            'article_id' => 'required|exists:articles,id',
        ]);

        Comment::create($validated);

        return redirect()
            ->back()
            ->with('message', 'Комментарий успешно добавлен!');
    }

    /**
     * Удаление комментария
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()
            ->back()
            ->with('message', 'Комментарий удалён!');
    }
}
