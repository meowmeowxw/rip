<?php

namespace App\Notifications;

use App\Models\SellerOrder;
use App\Models\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationChangeOrderStatus extends Notification
{
    use Queueable;

    public $sellerOrder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SellerOrder $sellerOrder)
    {
        $this->sellerOrder = $sellerOrder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /*
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
        */
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'status' => $this->sellerOrder->status->name,
            'order' => $this->sellerOrder->order->id,
            'url' => route('customer.order.id', $this->sellerOrder->order->id),
        ];
    }
}
