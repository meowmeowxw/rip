<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\SellerOrder;
use Illuminate\Queue\SerializesModels;

class ChangeOrderStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $sellerOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SellerOrder $sellerOrder)
    {
        $this->sellerOrder = $sellerOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Changed')
                    ->markdown('mail.order-changed', [
                        'url' => route('customer.order.id', $this->sellerOrder->order->id)
                    ]);
    }
}
