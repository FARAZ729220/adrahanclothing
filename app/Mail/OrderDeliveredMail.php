<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDeliveredMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('items');
    }

    public function build()
    {
        return $this->subject('Your Order Has Been Delivered - '.$this->order->order_number)
            ->markdown('emails.orders.delivered', [
                'order' => $this->order,
            ]);
    }
}
