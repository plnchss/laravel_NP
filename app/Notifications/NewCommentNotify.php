<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotify extends Notification
{
    use Queueable;

    protected $articleTitle;
    protected $articleId;

    /**
     * Создание экземпляра уведомления.
     */
    public function __construct($articleTitle, $articleId)
    {
        $this->articleTitle = $articleTitle;
        $this->articleId = $articleId;
    }

    /**
     * Через какие каналы будет отправлено уведомление.
     */
    public function via($notifiable)
    {
        return ['mail']; // только почта
    }

    /**
     * Формирование письма.
     */
    public function toMail($notifiable)
    {
        $url = url('/articles/' . $this->articleId);

        return (new MailMessage)
            ->subject('Новый комментарий к статье')
            ->greeting('Здравствуйте!')
            ->line('К статье "' . $this->articleTitle . '" добавлен новый комментарий.')
            ->action('Просмотреть статью', $url)
            ->line('Это уведомление отправлено автоматически.');
    }

    /**
     * (Необязательно) — если нужно хранить уведомления в БД
     */
    public function toArray($notifiable)
    {
        return [
            'article_id' => $this->articleId,
            'article_title' => $this->articleTitle,
        ];
    }
}
 