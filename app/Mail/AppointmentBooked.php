<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentBooked extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $doctorName;

    public function __construct(Appointment $appointment, $doctorName)
    {
        $this->appointment = $appointment;
        $this->doctorName = $doctorName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Booked - DocTime',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-booked',
            with: [
                'appointment' => $this->appointment,
                'doctorName' => $this->doctorName,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}