<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class NewBookingNotification extends Notification
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Booking Request')
            ->greeting('Hello Admin!')
            ->line('A new booking request has been received.')
            ->line('Booking Details:')
            ->line('Car: ' . ($this->booking->car ? $this->booking->car->name : ($this->booking->category ? $this->booking->category->name . ' (Category)' : 'N/A')))
            ->line('Customer Name: ' . $this->booking->customer_name)
            ->line('Customer Email: ' . $this->booking->customer_email)
            ->line('Customer Phone: ' . $this->booking->customer_phone)
            ->line('ID Type: ' . ucfirst($this->booking->id_type))
            ->line('ID Number: ' . $this->booking->id_number)
            ->line('Destination: ' . ucfirst($this->booking->destination))
            ->when($this->booking->region, function($message) {
                return $message->line('Region: ' . $this->booking->region);
            })
            ->line('Pickup Date: ' . $this->booking->pickup_date->format('M d, Y g:i A'))
            ->line('Return Date: ' . $this->booking->return_date->format('M d, Y g:i A'))
            ->line('Total Amount: $' . number_format($this->booking->total_amount, 2))
            ->when($this->booking->organization, function($message) {
                return $message->line('Organization: ' . $this->booking->organization);
            })
            ->when($this->booking->color, function($message) {
                return $message->line('Color Preference: ' . $this->booking->color);
            })
            ->action('View Booking', route('admin.bookings.show', $this->booking))
            ->line('Please review this booking request as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'customer_name' => $this->booking->customer_name,
            'customer_phone' => $this->booking->customer_phone,
            'customer_email' => $this->booking->customer_email,
            'pickup_date' => $this->booking->pickup_date,
            'return_date' => $this->booking->return_date,
            'category' => $this->booking->category ? $this->booking->category->name : null,
            'created_at' => $this->booking->created_at,
        ];
    }
}
