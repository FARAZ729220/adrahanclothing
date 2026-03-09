<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Contact Enquiry</title>
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
                    New Contact Enquiry
                </div>
            </div>

            {{-- Intro --}}
            <div style="padding:32px;">
                <h1
                    style="margin:0 0 12px 0;font-size:30px;line-height:1.2;font-family:Georgia, 'Times New Roman', serif;font-weight:700;color:#111;">
                    New enquiry received
                </h1>

                <p style="margin:0;font-size:15px;line-height:1.8;color:#555;">
                    A new contact form submission has been received from the website.
                </p>
            </div>

            {{-- Contact Info --}}
            <div style="padding:0 32px 28px 32px;">
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
                            style="padding:14px 16px;background:#faf8f5;border-bottom:1px solid #ece7de;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Phone
                        </td>
                        <td style="padding:14px 16px;border-bottom:1px solid #ece7de;font-size:15px;color:#111;">
                            {{ $mailData['phone'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:14px 16px;background:#faf8f5;font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#777;font-weight:700;">
                            Attachment
                        </td>
                        <td style="padding:14px 16px;font-size:15px;color:#111;">
                            {{ !empty($mailData['proof_image_path']) ? 'Attached with this email' : 'No attachment uploaded' }}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Message --}}
            <div style="padding:0 32px 32px 32px;">
                <div
                    style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#7a7a7a;font-weight:700;margin-bottom:12px;">
                    Message
                </div>

                <div
                    style="border:1px solid #ece7de;background:#faf8f5;padding:20px;font-size:15px;line-height:1.9;color:#222;">
                    {!! nl2br(e($mailData['message'])) !!}
                </div>
            </div>

            {{-- Footer --}}
            <div style="padding:24px 32px;border-top:1px solid #ece7de;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-size:13px;color:#777;line-height:1.8;">
                            Adrahan Clothing — Admin Notification
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
