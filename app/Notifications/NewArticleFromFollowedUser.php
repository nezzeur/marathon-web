<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Article;

class NewArticleFromFollowedUser extends Notification
{
    use Queueable;

    protected $article;

    /**
     * Create a new notification instance.
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvel article de ' . $this->article->editeur->name)
            ->line($this->article->editeur->name . ' a publié un nouvel article : ' . $this->article->titre)
            ->action('Voir l\'article', route('articles.show', $this->article->id))
            ->line('Merci d\'utiliser notre application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'article_id' => $this->article->id,
            'article_titre' => $this->article->titre,
            'auteur_id' => $this->article->editeur->id,
            'auteur_nom' => $this->article->editeur->name,
            'message' => $this->article->editeur->name . ' a publié un nouvel article : ' . $this->article->titre,
            'url' => route('articles.show', $this->article->id),
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
