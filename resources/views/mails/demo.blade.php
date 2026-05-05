<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; margin: 0; padding: 40px 0; }
        .container { max-width: 560px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: #6366f1; padding: 32px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 22px; letter-spacing: -0.5px; }
        .body { padding: 32px; color: #1e293b; }
        .body p { font-size: 15px; line-height: 1.7; color: #475569; }
        .message-box { background: #f8fafc; border-left: 4px solid #6366f1; padding: 16px 20px; border-radius: 0 8px 8px 0; margin: 20px 0; font-size: 15px; color: #1e293b; }
        .footer { background: #f8fafc; padding: 20px 32px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Creator File Storage</h1>
        </div>
        <div class="body">
            <p>Hello,</p>
            <p>You have received a new message from <strong>{{ $objDemo->sender }}</strong>:</p>
            <div class="message-box">
                {{ $objDemo->demo_one }} <br>
                {{ $objDemo->demo_two }}
            </div>
            <p>Thank you for using Creator File Storage.</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Creator File Storage. All rights reserved.
        </div>
    </div>
</body>
</html>
