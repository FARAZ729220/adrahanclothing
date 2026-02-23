<?php

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number','customer_name','customer_email','customer_phone','shipping_address',
        'payment_method','payment_status','delivery_status',
        'payment_proof_path','payment_reference_note',
        'subtotal','discount_total','grand_total'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}

