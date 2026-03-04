@php
    $isOnline = $order->payment_method === 'online_manual';
    $paymentMethodText = $isOnline ? 'Online (Manual)' : 'Cash on Delivery (COD)';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>

    <style>
        /* Email-safe CSS */
        body {
            margin: 0;
            padding: 0;
            background: #07070b;
            font-family: Arial, Helvetica, sans-serif;
            color: #eaeaf0;
        }

        .wrapper {
            width: 100%;
            background: #07070b;
            padding: 28px 14px;
        }

        .container {
            max-width: 720px;
            margin: 0 auto;
            background: #0b0b12;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 18px;
            overflow: hidden;
        }

        .header {
            padding: 22px 22px;
            background: radial-gradient(1200px circle at 30% 30%, rgba(168, 85, 247, 0.35), transparent 55%), #0b0b12;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .brand {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.3px;
        }

        .brand span {
            color: #a855f7;
        }

        .subtitle {
            margin-top: 8px;
            color: rgba(234, 234, 240, 0.75);
            font-size: 13px;
            line-height: 1.4;
        }

        .content {
            padding: 22px;
        }

        h1 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .badge {
            display: inline-block;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-purple {
            background: rgba(168, 85, 247, 0.16);
            color: #d8b4fe;
            border: 1px solid rgba(168, 85, 247, 0.35);
        }

        .muted {
            color: rgba(234, 234, 240, 0.70);
            font-size: 13px;
            line-height: 1.5;
        }

        .hr {
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin: 18px 0;
        }

        .card {
            background: #0f0f18;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 14px;
        }

        .row {
            width: 100%;
        }

        .row td {
            vertical-align: top;
        }

        .label {
            color: rgba(234, 234, 240, 0.65);
            font-size: 12px;
        }

        .value {
            color: #ffffff;
            font-weight: 700;
            font-size: 13px;
        }

        table.items {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        table.items th {
            text-align: left;
            padding: 10px;
            font-size: 12px;
            background: #111122;
            color: rgba(234, 234, 240, 0.85);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        table.items td {
            padding: 10px;
            font-size: 12px;
            color: rgba(234, 234, 240, 0.88);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        table.items tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totalBox {
            margin-top: 14px;
        }

        .totalRow {
            width: 100%;
        }

        .totalRow td {
            padding: 6px 0;
            font-size: 13px;
        }

        .totalRow .left {
            color: rgba(234, 234, 240, 0.75);
        }

        .totalRow .right {
            text-align: right;
            color: #fff;
            font-weight: 700;
        }

        .grand {
            font-size: 14px;
        }

        .footer {
            padding: 18px 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            color: rgba(234, 234, 240, 0.55);
            font-size: 12px;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 13px;
            color: #fff;
        }

        .btn-purple {
            background: linear-gradient(90deg, #a855f7, #7c3aed);
        }

        .small {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <div class="brand">Adrahan<span>.</span></div>
                <div class="subtitle">Your order is confirmed. We’ll update you as soon as it’s processed.</div>
            </div>

            <div class="content">
                <h1>Order Confirmed ✅</h1>

                <p class="muted" style="margin:0 0 10px 0;">
                    Hi <strong style="color:#fff;">{{ $order->customer_name }}</strong>, thank you for shopping with us.
                </p>

                <div style="margin:10px 0 0 0;">
                    <span class="badge badge-purple">Order: {{ $order->order_number }}</span>
                </div>

                <div class="hr"></div>

                <div class="card">
                    <table class="row" role="presentation">
                        <tr>
                            <td style="width:50%;">
                                <div class="label">Payment Method</div>
                                <div class="value">{{ $paymentMethodText }}</div>
                            </td>
                            <td style="width:50%;">
                                <div class="label">Payment Status</div>
                                <div class="value">{{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}</div>
                            </td>
                        </tr>
                    </table>

                    @if ($isOnline)
                        <div class="hr" style="margin:14px 0;"></div>
                        <div class="muted small">
                            We received your payment proof. Our team will verify it shortly.
                        </div>
                    @endif
                </div>

                <div class="hr"></div>

                <h1 style="font-size:15px; margin:0 0 10px 0;">Items</h1>

                <table class="items" role="presentation">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Size</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Unit</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td class="text-center">{{ $item->size ?? '-' }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-right">Rs {{ number_format($item->unit_price) }}</td>
                                <td class="text-right">Rs {{ number_format($item->line_total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="totalBox">
                    <table class="totalRow" role="presentation">
                        <tr>
                            <td class="left">Subtotal</td>
                            <td class="right">Rs {{ number_format($order->subtotal) }}</td>
                        </tr>
                        <tr>
                            <td class="left">Discount</td>
                            <td class="right">Rs {{ number_format($order->discount_total) }}</td>
                        </tr>
                        <tr>
                            <td class="left grand"><strong>Grand Total</strong></td>
                            <td class="right grand"><strong>Rs {{ number_format($order->grand_total) }}</strong></td>
                        </tr>
                    </table>
                </div>

                <div class="hr"></div>

                <h1 style="font-size:15px; margin:0 0 10px 0;">Shipping Address</h1>
                <div class="card">
                    <div class="muted" style="white-space:pre-line;">{{ $order->shipping_address }}</div>
                </div>

                <div style="margin-top:18px;">
                    <a class="btn btn-purple" href="{{ config('app.url') }}">Visit Store</a>
                </div>
            </div>

            <div class="footer">
                <div>Need help? Reply to this email.</div>
                <div style="margin-top:6px;">© {{ date('Y') }} Adrahan. All rights reserved.</div>
            </div>
        </div>
    </div>
</body>

</html>
