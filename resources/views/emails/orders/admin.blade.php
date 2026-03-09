@php
    $isOnline = $order->payment_method === 'online_manual';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Order Received</title>
</head>

<body style="margin:0;padding:0;background:#f5f2ed;font-family:Arial, Helvetica, sans-serif;color:#111;">

    <div style="width:100%;padding:40px 15px;background:#f5f2ed;">
        <div style="max-width:720px;margin:0 auto;background:#ffffff;border:1px solid #e8e2d9;">

            {{-- Header --}}
            <div style="padding:28px 32px;border-bottom:1px solid #ece7de;">
                <div style="font-size:34px;font-weight:700;line-height:1;color:#111;">
                    Adrahan Clothing<span style="color:#7a7a7a;">.</span>
                </div>
                <div style="margin-top:10px;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#7a7a7a;">
                    New Order Received
                </div>
            </div>

            {{-- Intro --}}
            <div style="padding:32px;">
                <h1
                    style="margin:0 0 12px 0;font-size:30px;line-height:1.2;font-family:Georgia, 'Times New Roman', serif;font-weight:700;color:#111;">
                    Order {{ $order->order_number }}
                </h1>

                <p style="margin:0;font-size:15px;line-height:1.8;color:#555;">
                    A new order has been placed on the website. Please review the details and verify payment if
                    required.
                </p>
            </div>

            {{-- Order Badge --}}
            <div style="padding:0 32px 20px 32px;">
                <div
                    style="display:inline-block;padding:9px 16px;border:1px solid #d9d1c5;background:#faf8f5;font-size:12px;letter-spacing:1px;text-transform:uppercase;font-weight:700;color:#444;">
                    Order Number: {{ $order->order_number }}
                </div>
            </div>

            {{-- Customer + Order Details --}}
            <div style="padding:0 32px 28px 32px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="border-collapse:collapse;border:1px solid #ece7de;">
                    <tr>
                        <td
                            style="padding:14px 16px;width:180px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Customer
                        </td>
                        <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            {{ $order->customer_name }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Phone
                        </td>
                        <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            {{ $order->customer_phone }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Email
                        </td>
                        <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            {{ $order->customer_email ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Payment Method
                        </td>
                        <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            {{ strtoupper($order->payment_method === 'cod' ? 'COD' : 'ONLINE (MANUAL)') }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Payment Status
                        </td>
                        <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Delivery Status
                        </td>
                        <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            {{ strtoupper($order->delivery_status) }}
                        </td>
                    </tr>

                    @if ($isOnline)
                        <tr>
                            <td
                                style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                                Payment Proof
                            </td>
                            <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                                {{ $order->payment_proof_path ? 'Uploaded' : 'Not uploaded' }}
                            </td>
                        </tr>

                        <tr>
                            <td
                                style="padding:14px 16px;background:#faf8f5;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                                Reference Note
                            </td>
                            <td style="padding:14px 16px;font-size:15px;color:#111;">
                                {{ $order->payment_reference_note ?? '-' }}
                            </td>
                        </tr>
                    @endif
                </table>
            </div>

            {{-- Items --}}
            <div style="padding:0 32px 12px 32px;">
                <div
                    style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#7a7a7a;font-weight:700;margin-bottom:12px;">
                    Order Items
                </div>

                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="border-collapse:collapse;border:1px solid #ece7de;">
                    <thead>
                        <tr>
                            <th align="left"
                                style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;">
                                Product</th>
                            <th align="center"
                                style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;">
                                Size</th>
                            <th align="center"
                                style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;">
                                Qty</th>
                            <th align="right"
                                style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;">
                                Unit</th>
                            <th align="right"
                                style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;">
                                Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td
                                    style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                                    {{ $item->product_name }}
                                </td>
                                <td align="center"
                                    style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                                    {{ $item->size ?? '-' }}
                                </td>
                                <td align="center"
                                    style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                                    {{ $item->quantity }}
                                </td>
                                <td align="right"
                                    style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                                    Rs {{ number_format($item->unit_price) }}
                                </td>
                                <td align="right"
                                    style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;font-weight:700;">
                                    Rs {{ number_format($item->line_total) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Shipping + Totals --}}
            <div style="padding:20px 32px 32px 32px;">
                <div
                    style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#7a7a7a;font-weight:700;margin-bottom:12px;">
                    Shipping Address
                </div>

                <div
                    style="border:1px solid #ece7de;background:#faf8f5;padding:18px;font-size:15px;line-height:1.8;color:#222;margin-bottom:20px;">
                    {!! nl2br(e($order->shipping_address)) !!}
                </div>

                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="border-collapse:collapse;border:1px solid #ece7de;">
                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Subtotal
                        </td>
                        <td align="right"
                            style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            Rs {{ number_format($order->subtotal) }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Discount
                        </td>
                        <td align="right"
                            style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            Rs {{ number_format($order->discount_total) }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Grand Total
                        </td>
                        <td align="right" style="padding:14px 16px;font-size:16px;color:#111;font-weight:700;">
                            Rs {{ number_format($order->grand_total) }}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Footer --}}
            <div style="padding:24px 32px;border-top:1px solid #ece7de;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-size:13px;color:#777;line-height:1.8;">
                            Adrahan Clothing — Admin Order Notification
                        </td>
                        <td align="right" style="font-size:13px;color:#777;">
                            {{ date('d M Y') }}
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

</body>

</html>
