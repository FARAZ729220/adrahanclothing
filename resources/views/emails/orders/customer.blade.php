@php
    $isOnline = $order->payment_method === 'online_manual';
    $paymentMethodText = $isOnline ? 'Online (Manual)' : 'Cash on Delivery (COD)';

    $statusText = strtoupper(str_replace('_', ' ', $order->payment_status));
    $storeUrl = config('app.url');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Confirmation</title>
</head>

<body style="margin:0;padding:0;background:#07070b;">
    <!-- PREHEADER (hidden) -->
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">
        Your order {{ $order->order_number }} is confirmed. We’ll update you as it’s processed.
    </div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
        style="background:#07070b; padding:24px 12px; font-family:Arial, Helvetica, sans-serif;">
        <tr>
            <td align="center">
                <!-- Outer container -->
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="max-width:680px; background:#0b0b12; border:1px solid rgba(255,255,255,0.08); border-radius:18px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="padding:22px 22px 18px 22px; background:#0b0b12;">
                            <!-- top glow bar -->
                            <div
                                style="height:3px; background:linear-gradient(90deg,#a855f7,#7c3aed); border-radius:999px;">
                            </div>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="margin-top:14px;">
                                <tr>
                                    <td align="left"
                                        style="color:#ffffff; font-size:20px; font-weight:800; letter-spacing:0.2px;">
                                        Adrahan<span style="color:#a855f7;">.</span>
                                    </td>
                                    <td align="right" style="color:rgba(234,234,240,0.70); font-size:12px;">
                                        {{ date('d M Y') }}
                                    </td>
                                </tr>
                            </table>

                            <div
                                style="margin-top:10px; color:rgba(234,234,240,0.78); font-size:13px; line-height:1.5;">
                                Your order is confirmed. We’ll update you as soon as it’s processed.
                            </div>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:22px;">
                            <!-- Title -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="color:#ffffff; font-size:18px; font-weight:800;">
                                        Order Confirmed ✅
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding-top:8px; color:rgba(234,234,240,0.78); font-size:13px; line-height:1.6;">
                                        Hi <span
                                            style="color:#ffffff; font-weight:700;">{{ $order->customer_name }}</span>,
                                        thank you for shopping with us.
                                    </td>
                                </tr>
                            </table>

                            <!-- Order pill -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                style="margin-top:14px;">
                                <tr>
                                    <td
                                        style="background:rgba(168,85,247,0.14); border:1px solid rgba(168,85,247,0.35);
                                        color:#d8b4fe; font-size:12px; font-weight:800; padding:8px 12px; border-radius:999px;">
                                        Order: {{ $order->order_number }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <div style="height:1px; background:rgba(255,255,255,0.08); margin:18px 0;"></div>

                            <!-- Payment card -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="background:#0f0f18; border:1px solid rgba(255,255,255,0.08); border-radius:14px;">
                                <tr>
                                    <td style="padding:14px 14px 10px 14px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                            border="0">
                                            <tr>
                                                <td width="50%" valign="top" style="padding-right:10px;">
                                                    <div style="color:rgba(234,234,240,0.65); font-size:12px;">Payment
                                                        Method</div>
                                                    <div
                                                        style="color:#ffffff; font-size:13px; font-weight:800; margin-top:4px;">
                                                        {{ $paymentMethodText }}
                                                    </div>
                                                </td>
                                                <td width="50%" valign="top" style="padding-left:10px;">
                                                    <div style="color:rgba(234,234,240,0.65); font-size:12px;">Payment
                                                        Status</div>

                                                    <!-- status chip -->
                                                    <div
                                                        style="margin-top:6px; display:inline-block; padding:7px 10px; border-radius:999px;
                                                        font-size:12px; font-weight:800; color:#ffffff;
                                                        background:@if ($order->payment_status === 'paid') rgba(34,197,94,0.18) @else rgba(245,158,11,0.18) @endif;
                                                        border:1px solid @if ($order->payment_status === 'paid') rgba(34,197,94,0.40) @else rgba(245,158,11,0.40) @endif;">
                                                        {{ $statusText }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        @if ($isOnline)
                                            <div style="height:1px; background:rgba(255,255,255,0.08); margin:12px 0;">
                                            </div>
                                            <div style="color:rgba(234,234,240,0.78); font-size:12px; line-height:1.6;">
                                                We received your payment proof. Our team will verify it shortly.
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <div style="height:1px; background:rgba(255,255,255,0.08); margin:18px 0;"></div>

                            <!-- Items heading -->
                            <div style="color:#ffffff; font-size:14px; font-weight:800; margin-bottom:10px;">
                                Items
                            </div>

                            <!-- Items table wrapper -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="border:1px solid rgba(255,255,255,0.08); border-radius:14px; overflow:hidden; background:#0f0f18;">
                                <tr>
                                    <td>
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                            border="0">
                                            <tr>
                                                <td
                                                    style="padding:10px; background:#111122; color:rgba(234,234,240,0.90); font-size:12px; font-weight:800;">
                                                    Product
                                                </td>
                                                <td align="center"
                                                    style="padding:10px; background:#111122; color:rgba(234,234,240,0.90); font-size:12px; font-weight:800;">
                                                    Size
                                                </td>
                                                <td align="center"
                                                    style="padding:10px; background:#111122; color:rgba(234,234,240,0.90); font-size:12px; font-weight:800;">
                                                    Qty
                                                </td>
                                                <td align="right"
                                                    style="padding:10px; background:#111122; color:rgba(234,234,240,0.90); font-size:12px; font-weight:800;">
                                                    Unit
                                                </td>
                                                <td align="right"
                                                    style="padding:10px; background:#111122; color:rgba(234,234,240,0.90); font-size:12px; font-weight:800;">
                                                    Total
                                                </td>
                                            </tr>

                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td
                                                        style="padding:10px; color:rgba(234,234,240,0.92); font-size:12px; border-top:1px solid rgba(255,255,255,0.08);">
                                                        {{ $item->product_name }}
                                                    </td>
                                                    <td align="center"
                                                        style="padding:10px; color:rgba(234,234,240,0.88); font-size:12px; border-top:1px solid rgba(255,255,255,0.08);">
                                                        {{ $item->size ?? '-' }}
                                                    </td>
                                                    <td align="center"
                                                        style="padding:10px; color:rgba(234,234,240,0.88); font-size:12px; border-top:1px solid rgba(255,255,255,0.08);">
                                                        {{ $item->quantity }}
                                                    </td>
                                                    <td align="right"
                                                        style="padding:10px; color:rgba(234,234,240,0.88); font-size:12px; border-top:1px solid rgba(255,255,255,0.08);">
                                                        Rs {{ number_format($item->unit_price) }}
                                                    </td>
                                                    <td align="right"
                                                        style="padding:10px; color:#ffffff; font-size:12px; font-weight:800; border-top:1px solid rgba(255,255,255,0.08);">
                                                        Rs {{ number_format($item->line_total) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Totals -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                border="0" style="margin-top:14px;">
                                <tr>
                                    <td style="color:rgba(234,234,240,0.78); font-size:13px;">Subtotal</td>
                                    <td align="right" style="color:#ffffff; font-size:13px; font-weight:800;">
                                        Rs {{ number_format($order->subtotal) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:6px; color:rgba(234,234,240,0.78); font-size:13px;">Discount
                                    </td>
                                    <td align="right"
                                        style="padding-top:6px; color:#ffffff; font-size:13px; font-weight:800;">
                                        Rs {{ number_format($order->discount_total) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:10px; color:#ffffff; font-size:14px; font-weight:900;">
                                        Grand Total
                                    </td>
                                    <td align="right"
                                        style="padding-top:10px; color:#ffffff; font-size:14px; font-weight:900;">
                                        Rs {{ number_format($order->grand_total) }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <div style="height:1px; background:rgba(255,255,255,0.08); margin:18px 0;"></div>

                            <!-- Shipping -->
                            <div style="color:#ffffff; font-size:14px; font-weight:800; margin-bottom:10px;">
                                Shipping Address
                            </div>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                border="0"
                                style="background:#0f0f18; border:1px solid rgba(255,255,255,0.08); border-radius:14px;">
                                <tr>
                                    <td
                                        style="padding:14px; color:rgba(234,234,240,0.86); font-size:12px; line-height:1.7; white-space:pre-line;">
                                        {{ $order->shipping_address }}
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                style="margin-top:18px;">
                                <tr>
                                    <td>
                                        <a href="{{ $storeUrl }}" target="_blank"
                                            style="display:inline-block; text-decoration:none; padding:12px 16px; border-radius:999px;
                                            color:#ffffff; font-size:13px; font-weight:900; background:linear-gradient(90deg,#a855f7,#7c3aed);">
                                            Visit Store
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Small note -->
                            <div
                                style="margin-top:16px; color:rgba(234,234,240,0.60); font-size:12px; line-height:1.6;">
                                Need help? Reply to this email and we’ll get back to you.
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="padding:16px 22px; border-top:1px solid rgba(255,255,255,0.08);
                            color:rgba(234,234,240,0.55); font-size:12px; background:#0b0b12;">
                            © {{ date('Y') }} Adrahan. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
