<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('items');
    }

    public function build()
    {
        return $this->subject('Order Cancelled - '.$this->order->order_number)
            ->markdown('emails.orders.cancelled', [
                'order' => $this->order,
            ]);
    }
}
