<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>We Received Your Message</title>
</head>

<body style="margin:0;padding:0;background:#f5f2ed;font-family:Arial, Helvetica, sans-serif;color:#111;">

    <div style="width:100%;padding:40px 15px;background:#f5f2ed;">
        <div style="max-width:720px;margin:0 auto;background:#ffffff;border:1px solid #e8e2d9;">

            {{-- Header --}}
            <div style="padding:28px 32px;border-bottom:1px solid #ece7de;">
                <div style="font-size:34px;font-weight:700;line-height:1;color:#111;">
                    Adrahan<span style="color:#7a7a7a;">Clothing.</span>
                </div>
                <div style="margin-top:10px;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#7a7a7a;">
                    Contact Confirmation
                </div>
            </div>

            {{-- Intro --}}
            <div style="padding:32px;">
                <h1
                    style="margin:0 0 14px 0;font-size:34px;line-height:1.2;font-family:Georgia, 'Times New Roman', serif;font-weight:700;color:#111;">
                    Thank you for reaching out
                </h1>

                <p style="margin:0 0 14px 0;font-size:15px;line-height:1.9;color:#555;">
                    Hi {{ $mailData['name'] }},
                </p>

                <p style="margin:0;font-size:15px;line-height:1.9;color:#555;">
                    We’ve successfully received your message and our team will review it shortly.
                    We appreciate your interest in <strong style="color:#111;">Adrahan</strong> and will get back to you
                    as soon as possible.
                </p>
            </div>

            {{-- User Message Preview --}}
            <div style="padding:0 32px 28px 32px;">
                <div
                    style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#7a7a7a;font-weight:700;margin-bottom:12px;">
                    Your Message
                </div>

                <div
                    style="border:1px solid #ece7de;background:#faf8f5;padding:20px;font-size:15px;line-height:1.9;color:#222;">
                    {!! nl2br(e($mailData['message'])) !!}
                </div>
            </div>

            {{-- Optional Details --}}
            <div style="padding:0 32px 32px 32px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="border-collapse:collapse;border:1px solid #ece7de;">
                    <tr>
                        <td
                            style="padding:14px 16px;width:180px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Name
                        </td>
                        <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            {{ $mailData['name'] }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Email
                        </td>
                        <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            {{ $mailData['email'] }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Phone
                        </td>
                        <td style="padding:14px 16px;font-size:15px;color:#111;">
                            {{ $mailData['phone'] ?? '-' }}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- CTA --}}
            <div style="padding:0 32px 36px 32px;text-align:left;">
                <a href="{{ config('app.url') }}"
                    style="display:inline-block;padding:14px 26px;border:1px solid #111;background:#111;color:#fff;text-decoration:none;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">
                    Visit Store
                </a>
            </div>

            {{-- Footer --}}
            <div style="padding:24px 32px;border-top:1px solid #ece7de;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-size:13px;color:#777;line-height:1.8;">
                            Timeless fashion for the modern wardrobe.
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
