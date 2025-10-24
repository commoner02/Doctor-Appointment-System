
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Booked</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #20b2aa; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .appointment-details { background: white; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DocTime</h1>
            <h2>Appointment Confirmed</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $appointment->patient->user->name }},</p>
            
            <p>Your appointment has been successfully booked with {{ $doctorName }}.</p>
            
            <div class="appointment-details">
                <h3>Appointment Details:</h3>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</p>
                @if($appointment->appointment_time)
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</p>
                @endif
                <p><strong>Doctor:</strong> {{ $doctorName }}</p>
                @if($appointment->chamber)
                    <p><strong>Chamber:</strong> {{ $appointment->chamber->name }}</p>
                    @if($appointment->chamber->address)
                        <p><strong>Address:</strong> {{ $appointment->chamber->address }}</p>
                    @endif
                @endif
                @if($appointment->fee)
                    <p><strong>Consultation Fee:</strong> ৳{{ number_format($appointment->fee) }}</p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($appointment->payment_status) }}</p>
                @endif
                @if($appointment->notes)
                    <p><strong>Notes:</strong> {{ $appointment->notes }}</p>
                @endif
            </div>
            
            <p>Please arrive 15 minutes before your scheduled time. If you need to reschedule or cancel, please contact us as soon as possible.</p>
            
            <p>Thank you for choosing DocTime!</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} DocTime. All rights reserved.</p>
        </div>
    </div>
</body>
</html>