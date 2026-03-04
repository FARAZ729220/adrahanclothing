@php
    $isOnline = $order->payment_method === 'online_manual';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order</title>

    <style>
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
            padding: 22px;
            background: radial-gradient(1100px circle at 30% 30%, rgba(168, 85, 247, 0.30), transparent 55%), #0b0b12;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .brand {
            font-size: 20px;
            font-weight: 800;
        }

        .brand span {
            color: #a855f7;
        }

        .subtitle {
            margin-top: 8px;
            color: rgba(234, 234, 240, 0.70);
            font-size: 13px;
        }

        .content {
            padding: 22px;
        }

        .badge {
            display: inline-block;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            background: rgba(168, 85, 247, 0.16);
            color: #d8b4fe;
            border: 1px solid rgba(168, 85, 247, 0.35);
        }

        .card {
            background: #0f0f18;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 14px;
        }

        .label {
            color: rgba(234, 234, 240, 0.60);
            font-size: 12px;
        }

        .value {
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            margin-top: 2px;
        }

        .hr {
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin: 18px 0;
        }

        table.items {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            overflow: hidden;
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

        .footer {
            padding: 18px 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            color: rgba(234, 234, 240, 0.55);
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <div class="brand">Adrahan<span>.</span></div>
                <div class="subtitle">New order received — review details and verify payment if required.</div>
            </div>

            <div class="content">
                <div style="margin-bottom:12px;">
                    <span class="badge">New Order: {{ $order->order_number }}</span>
                </div>

                <div class="card">
                    <table role="presentation" style="width:100%;">
                        <tr>
                            <td style="width:50%; padding-bottom:10px;">
                                <div class="label">Customer</div>
                                <div class="value">{{ $order->customer_name }}</div>
                            </td>
                            <td style="width:50%; padding-bottom:10px;">
                                <div class="label">Phone</div>
                                <div class="value">{{ $order->customer_phone }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%;">
                                <div class="label">Email</div>
                                <div class="value">{{ $order->customer_email ?? '-' }}</div>
                            </td>
                            <td style="width:50%;">
                                <div class="label">Payment</div>
                                <div class="value">
                                    {{ strtoupper($order->payment_method === 'cod' ? 'COD' : 'ONLINE (MANUAL)') }}</div>
                            </td>
                        </tr>
                    </table>

                    @if ($isOnline)
                        <div class="hr" style="margin:14px 0;"></div>
                        <div class="label">Payment Proof</div>
                        <div class="value">{{ $order->payment_proof_path ? 'Uploaded ✅' : 'Not uploaded ❌' }}</div>

                        <div style="margin-top:10px;" class="label">Reference Note</div>
                        <div class="value">{{ $order->payment_reference_note ?? '-' }}</div>
                    @endif
                </div>

                <div class="hr"></div>

                <h3 style="margin:0 0 10px 0; font-size:15px;">Items</h3>

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

                <div class="hr"></div>

                <div class="card">
                    <div class="label">Shipping Address</div>
                    <div class="value" style="white-space:pre-line; font-weight:600;">{{ $order->shipping_address }}
                    </div>

                    <div class="hr" style="margin:14px 0;"></div>

                    <table role="presentation" style="width:100%;">
                        <tr>
                            <td class="label">Subtotal</td>
                            <td class="value" style="text-align:right;">Rs {{ number_format($order->subtotal) }}</td>
                        </tr>
                        <tr>
                            <td class="label">Discount</td>
                            <td class="value" style="text-align:right;">Rs {{ number_format($order->discount_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label"><strong>Grand Total</strong></td>
                            <td class="value" style="text-align:right;"><strong>Rs
                                    {{ number_format($order->grand_total) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="footer">
                <div>Admin notification — verify and process the order in your dashboard.</div>
                <div style="margin-top:6px;">© {{ date('Y') }} Adrahan. All rights reserved.</div>
            </div>
        </div>
    </div>
</body>

</html>
