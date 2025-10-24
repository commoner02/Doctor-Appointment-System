
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Email</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #20b2aa; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DocTime</h1>
            <h2>Test Email</h2>
        </div>
        
        <div class="content">
            <p>Hello!</p>
            
            <p>This is a test email from DocTime to verify that email functionality is working correctly.</p>
            
            <p>If you received this email, it means the email configuration is set up properly!</p>
            
            <p>Sent at: {{ now()->format('Y-m-d H:i:s') }}</p>
            
            <p>Best regards,<br>DocTime Team</p>
        </div>
        
        <div class="footer">
            <p>This is an automated test message.</p>
            <p>&copy; {{ date('Y') }} DocTime. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
EOF