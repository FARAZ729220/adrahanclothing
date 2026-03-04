<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPaymentUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('items');
    }

    public function build()
    {
        return $this->subject('Payment Status Updated - '.$this->order->order_number)
            ->markdown('emails.orders.payment_updated', [
                'order' => $this->order,
            ]);
    }
}
