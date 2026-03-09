@php
    $status = strtoupper($order->payment_status);
    $method = $order->payment_method === 'cod' ? 'Cash on Delivery (COD)' : 'Online (Manual)';

@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Status Updated</title>
</head>

<body style="margin:0;padding:0;background:#f5f2ed;font-family:Arial, Helvetica, sans-serif;color:#111;">

<div style="width:100%;padding:40px 15px;background:#f5f2ed;">
<div style="max-width:720px;margin:0 auto;background:#ffffff;border:1px solid #e8e2d9;">

    <!-- Header -->
    <div style="padding:28px 32px;border-bottom:1px solid #ece7de;">
        <div style="font-size:34px;font-weight:700;line-height:1;color:#111;">
            Adrahan<span style="color:#7a7a7a;">Clothing.</span>
        </div>

        <div style="margin-top:10px;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#7a7a7a;">
            Payment Update
        </div>
    </div>

    <!-- Intro -->
    <div style="padding:32px;">

        <h1 style="margin:0 0 14px 0;font-size:34px;line-height:1.2;font-family:Georgia, 'Times New Roman', serif;font-weight:700;color:#111;">
            Your payment status has been updated
        </h1>

        <p style="margin:0 0 14px 0;font-size:15px;line-height:1.9;color:#555;">
            Hi {{ $order->customer_name }},
        </p>

        <p style="margin:0;font-size:15px;line-height:1.9;color:#555;">
            The payment status for your order <strong>{{ $order->order_number }}</strong> has been updated.
        </p>

    </div>

    <!-- Payment Status -->
    <div style="padding:0 32px 28px 32px;">

        <table width="100%" cellpadding="0" cellspacing="0" border="0"
               style="border-collapse:collapse;border:1px solid #ece7de;">

            <tr>
                <td style="padding:14px 16px;width:180px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                    Order Number
                </td>

                <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                    {{ $order->order_number }}
                </td>
            </tr>

            <tr>
                <td style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                    Payment Status
                </td>

                <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;font-weight:700;">
                    {{ $status }}
                </td>
            </tr>

            <tr>
                <td style="padding:14px 16px;background:#faf8f5;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                    Payment Method
                </td>

                <td style="padding:14px 16px;font-size:15px;color:#111;">
                    {{ $method }}
                </td>
            </tr>

        </table>

        @if($order->payment_method === 'online_manual')
        <div style="margin-top:14px;border:1px solid #ece7de;background:#faf8f5;padding:16px;font-size:14px;line-height:1.8;color:#555;">
            If you uploaded a payment proof, our team will verify it shortly and update your order.
        </div>
        @endif

    </div>

    <!-- CTA -->
    <div style="padding:0 32px 36px 32px;text-align:left;">
        <a href="{{ config('app.url') }}"
           style="display:inline-block;padding:14px 26px;border:1px solid #111;background:#111;color:#fff;text-decoration:none;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">
            Visit Store
        </a>
    </div>

    <!-- Footer -->
    <div style="padding:24px 32px;border-top:1px solid #ece7de;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="font-size:13px;color:#777;line-height:1.8;">
                    Need help? Reply to this email and our support team will assist you.
                </td>

                <td align="right" style="font-size:13px;color:#777;">
                    © {{ date('Y') }} Adrahan Clothing
                </td>
            </tr>
        </table>
    </div>

</div>
</div>

</body>
</html>
