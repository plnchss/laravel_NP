<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewCommentNotify;

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

        // Создаём комментарий
        $comment = Comment::create($validated);

        // Находим всех модераторов
        $moderators = User::where('role', 'moderator')->get();

        // Отправляем письма модераторам
        if ($moderators->isNotEmpty()) {
            Notification::send($moderators, new NewCommentNotify(
                $comment->article->title,
                $comment->article->id
            ));
        }

        return redirect()
            ->back()
            ->with('message', 'Комментарий успешно добавлен!');
    }

    /**
     * Удаление комментария
     */
    public function destroy(Comment $comment)
    {
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
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'text' => 'required|string|max:500',
        ]);

        $comment->update($validated);

        return redirect()
            ->back()
            ->with('message', 'Комментарий успешно обновлён!');
    }

    /**
     * Одобрение комментария (для модератора)
     */
    public function accept(Comment $comment)
    {
        $this->authorize('accept', $comment);

        $comment->accept = true;

        if ($comment->save()) {
            $article = Article::findOrFail($comment->article_id);
            $users = User::where('id', '!=', $comment->user_id)->get();

            Notification::send($users, new NewCommentNotify($article->title, $article->id));

            Cache::forget('comments' . $article->id);
        }

        return redirect()
            ->back()
            ->with('message', 'Комментарий успешно одобрен!');
    }
}
