<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Appointment Cancelled</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background: #f9f9f9;
        }

        .appointment-details {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>DocTime</h1>
            <h2>Appointment Cancelled</h2>
        </div>

        <div class="content">
            <p>Dear {{ $appointment->patient->user->name }},</p>

            <p>We regret to inform you that your appointment with {{ $appointment->doctor->user->name }} has been
                cancelled.
            </p>

            <div class="appointment-details">
                <h3>Cancelled Appointment Details:</h3>
                <p><strong>Date:</strong>
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</p>
                @if($appointment->appointment_time)
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                    </p>
                @endif
                <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
                @if($appointment->chamber)
                    <p><strong>Chamber:</strong> {{ $appointment->chamber->name }}</p>
                @endif
            </div>

            @if($appointment->notes)
                <p><strong>Cancellation Reason:</strong> {{ $appointment->notes }}</p>
            @endif

            <p>If you would like to reschedule, please visit our website or contact the doctor's office directly.</p>

            <p>We apologize for any inconvenience caused.</p>
        </div>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} DocTime. All rights reserved.</p>
        </div>
    </div>
</body>

</html>