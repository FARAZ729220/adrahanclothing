@php
    $brand = config('Adrahan');
    $status = strtoupper($order->payment_status);
    $method = $order->payment_method === 'cod' ? 'Cash on Delivery (COD)' : 'Online (Manual)';
@endphp

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Status Updated</title>
</head>
<body style="margin:0;background:#0b0b10;font-family:Arial,Helvetica,sans-serif;color:#fff;">
<div style="max-width:680px;margin:0 auto;padding:28px;">
    <div style="background:linear-gradient(135deg,#6d28d9,#d946ef);padding:20px 24px;border-radius:16px;">
        <div style="font-weight:800;font-size:20px;letter-spacing:.2px;">{{ $brand }}.</div>
        <div style="opacity:.9;margin-top:6px;">Your payment status has been updated.</div>
    </div>

    <div style="margin-top:18px;background:#11131a;border:1px solid rgba(255,255,255,.08);border-radius:16px;padding:18px 20px;">
        <div style="font-size:14px;opacity:.85;">Hi <b>{{ $order->customer_name }}</b>,</div>
        <div style="margin-top:10px;font-size:14px;opacity:.85;">
            Your payment status for order <b>{{ $order->order_number }}</b> is now:
        </div>

        <div style="margin-top:14px;display:inline-block;padding:8px 12px;border-radius:999px;background:rgba(217,70,239,.15);border:1px solid rgba(217,70,239,.35);font-weight:700;">
            {{ $status }}
        </div>

        <div style="margin-top:14px;font-size:13px;opacity:.75;">
            Payment Method: <b>{{ $method }}</b>
        </div>

        @if($order->payment_method === 'online_manual')
            <div style="margin-top:10px;font-size:13px;opacity:.75;">
                If you uploaded a proof, our team will verify it shortly.
            </div>
        @endif
    </div>

    <div style="margin-top:16px;font-size:12px;opacity:.55;text-align:center;">
        Need help? Reply to this email.
        <div style="margin-top:8px;">© {{ date('Y') }} {{ $brand }}. All rights reserved.</div>
    </div>
</div>
</body>
</html>
