<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class WelcomeUserNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name') . ' - Your Account Details')
            ->greeting('Hello ' . $this->user->name . '!')
            ->line('Welcome to ' . config('app.name') . '! Your account has been created successfully.')
            ->line('Here are your login credentials:')
            ->line('Email: ' . $this->user->email)
            ->line('Password: ' . $this->password)
            ->action('Login to Your Account', route('login'))
            ->line('Please change your password after your first login for security purposes.')
            ->line('If you have any questions, please contact our support team.')
            ->line('Thank you for choosing our service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'message' => 'Welcome email sent to ' . $this->user->email,
        ];
    }
}
