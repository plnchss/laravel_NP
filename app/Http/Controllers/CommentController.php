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
        // Проверяем поля
        $validated = $request->validate([
            'text' => 'required|string|max:500',
            'article_id' => 'required|exists:articles,id',
        ]);

        // Добавляем ID текущего пользователя
        $validated['user_id'] = auth()->id();

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
        // Проверяем право удаления через политику
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()
            ->back()
            ->with('message', 'Комментарий удалён!');
    }

    /**
     * Обновление (редактирование) комментария
     */
    public function update(Request $request, Comment $comment)
    {
        // Проверяем право редактирования через политику
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'text' => 'required|string|max:500',
        ]);

        $comment->update($validated);

        return redirect()
            ->back()
            ->with('message', 'Комментарий успешно обновлён!');
    }
}
