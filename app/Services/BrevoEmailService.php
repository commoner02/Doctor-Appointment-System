<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;

class BrevoEmailService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.brevo.api_key');
        $this->client = new Client([
            'base_uri' => 'https://api.brevo.com/v3/',
            'headers' => [
                'api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function sendAppointmentBooked($appointment)
    {
        try {
            $patient = $appointment->patient;
            $doctor = $appointment->doctor;
            $chamber = $appointment->chamber;

            // Email to patient
            $patientData = [
                'sender' => [
                    'email' => config('mail.from.address'),
                    'name' => config('mail.from.name'),
                ],
                'to' => [
                    [
                        'email' => $patient->user->email,
                        'name' => $patient->user->name,
                    ],
                ],
                'subject' => 'Appointment Booked - DocTime',
                'htmlContent' => $this->getAppointmentBookedHtml($appointment, 'patient'),
                'textContent' => $this->getAppointmentBookedText($appointment, 'patient'),
            ];

            $this->client->post('smtp/email', [
                'json' => $patientData,
            ]);

            // Email to doctor
            $doctorData = [
                'sender' => [
                    'email' => config('mail.from.address'),
                    'name' => config('mail.from.name'),
                ],
                'to' => [
                    [
                        'email' => $doctor->user->email,
                        'name' => 'Dr. ' . $doctor->user->name,
                    ],
                ],
                'subject' => 'New Appointment Booked - DocTime',
                'htmlContent' => $this->getAppointmentBookedHtml($appointment, 'doctor'),
                'textContent' => $this->getAppointmentBookedText($appointment, 'doctor'),
            ];

            $this->client->post('smtp/email', [
                'json' => $doctorData,
            ]);

            return true;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : 'No response';
            \Log::error('Brevo API Error - Appointment Booked: ' . $e->getMessage() . ' - Response: ' . $errorBody);
            return false;
        } catch (Exception $e) {
            \Log::error('Brevo API Error - Appointment Booked: ' . $e->getMessage());
            return false;
        }
    }

    public function sendAppointmentCompleted($appointment)
    {
        try {
            $patient = $appointment->patient;

            $data = [
                'sender' => [
                    'email' => config('mail.from.address'),
                    'name' => config('mail.from.name'),
                ],
                'to' => [
                    [
                        'email' => $patient->user->email,
                        'name' => $patient->user->name,
                    ],
                ],
                'subject' => 'Appointment Completed - DocTime',
                'htmlContent' => $this->getAppointmentCompletedHtml($appointment),
                'textContent' => $this->getAppointmentCompletedText($appointment),
            ];

            $this->client->post('smtp/email', [
                'json' => $data,
            ]);

            return true;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : 'No response';
            \Log::error('Brevo API Error - Appointment Completed: ' . $e->getMessage() . ' - Response: ' . $errorBody);
            return false;
        } catch (Exception $e) {
            \Log::error('Brevo API Error - Appointment Completed: ' . $e->getMessage());
            return false;
        }
    }

    public function sendAppointmentCancelled($appointment)
    {
        try {
            $patient = $appointment->patient;
            $doctor = $appointment->doctor;

            // Email to patient
            $patientData = [
                'sender' => [
                    'email' => config('mail.from.address'),
                    'name' => config('mail.from.name'),
                ],
                'to' => [
                    [
                        'email' => $patient->user->email,
                        'name' => $patient->user->name,
                    ],
                ],
                'subject' => 'Appointment Cancelled - DocTime',
                'htmlContent' => $this->getAppointmentCancelledHtml($appointment, 'patient'),
                'textContent' => $this->getAppointmentCancelledText($appointment, 'patient'),
            ];

            $this->client->post('smtp/email', [
                'json' => $patientData,
            ]);

            // Email to doctor
            $doctorData = [
                'sender' => [
                    'email' => config('mail.from.address'),
                    'name' => config('mail.from.name'),
                ],
                'to' => [
                    [
                        'email' => $doctor->user->email,
                        'name' => 'Dr. ' . $doctor->user->name,
                    ],
                ],
                'subject' => 'Appointment Cancelled - DocTime',
                'htmlContent' => $this->getAppointmentCancelledHtml($appointment, 'doctor'),
                'textContent' => $this->getAppointmentCancelledText($appointment, 'doctor'),
            ];

            $this->client->post('smtp/email', [
                'json' => $doctorData,
            ]);

            return true;
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $errorBody = $response ? $response->getBody()->getContents() : 'No response';
            \Log::error('Brevo API Error - Appointment Cancelled: ' . $e->getMessage() . ' - Response: ' . $errorBody);
            return false;
        } catch (Exception $e) {
            \Log::error('Brevo API Error - Appointment Cancelled: ' . $e->getMessage());
            return false;
        }
    }

    private function getAppointmentBookedHtml($appointment, $recipient = 'patient')
    {
        $patient = $appointment->patient;
        $doctor = $appointment->doctor;
        $chamber = $appointment->chamber;

        if ($recipient === 'patient') {
            $greeting = "Dear {$patient->user->name},";
            $message = "Your appointment has been successfully booked with the following details:";
        } else {
            $greeting = "Dear Dr. {$doctor->user->name},";
            $message = "A new appointment has been booked with the following details:";
        }

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px; }
                .appointment-details { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #2563eb; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Appointment Booked</h1>
                </div>
                <div class='content'>
                    <p>{$greeting}</p>
                    <p>{$message}</p>
                    <div class='appointment-details'>
                        <p><strong>Doctor:</strong> Dr. {$doctor->user->name}</p>
                        <p><strong>Speciality:</strong> {$doctor->speciality}</p>
                        <p><strong>Chamber:</strong> {$chamber->name}</p>
                        <p><strong>Address:</strong> {$chamber->address}</p>
                        <p><strong>Date & Time:</strong> {$appointment->appointment_date->format('l, F j, Y \a\t g:i A')}</p>
                        " . ($appointment->reason ? "<p><strong>Reason:</strong> {$appointment->reason}</p>" : "") . "
                    </div>
                    <p><strong>Important:</strong> Please arrive 15 minutes before your scheduled time.</p>
                    <p>Best regards,<br><strong>DocTime Team</strong></p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getAppointmentBookedText($appointment, $recipient = 'patient')
    {
        $patient = $appointment->patient;
        $doctor = $appointment->doctor;
        $chamber = $appointment->chamber;

        if ($recipient === 'patient') {
            $greeting = "Dear {$patient->user->name},";
        } else {
            $greeting = "Dear Dr. {$doctor->user->name},";
        }

        return "{$greeting}

Your appointment has been successfully booked.

Doctor: Dr. {$doctor->user->name}
Speciality: {$doctor->speciality}
Chamber: {$chamber->name}
Address: {$chamber->address}
Date & Time: {$appointment->appointment_date->format('l, F j, Y \a\t g:i A')}" .
            ($appointment->reason ? "\nReason: {$appointment->reason}" : "") . "

Please arrive 15 minutes before your scheduled time.

Best regards,
DocTime Team";
    }

    private function getAppointmentCompletedHtml($appointment)
    {
        $patient = $appointment->patient;
        $doctor = $appointment->doctor;

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #10b981; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Appointment Completed</h1>
                </div>
                <div class='content'>
                    <p>Dear {$patient->user->name},</p>
                    <p>Your appointment with Dr. {$doctor->user->name} has been completed successfully.</p>
                    <p>Thank you for choosing DocTime. We hope to serve you again.</p>
                    <p>Best regards,<br><strong>DocTime Team</strong></p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getAppointmentCompletedText($appointment)
    {
        $patient = $appointment->patient;
        $doctor = $appointment->doctor;

        return "Dear {$patient->user->name},

Your appointment with Dr. {$doctor->user->name} has been completed successfully.

Thank you for choosing DocTime. We hope to serve you again.

Best regards,
DocTime Team";
    }

    private function getAppointmentCancelledHtml($appointment, $recipient = 'patient')
    {
        $patient = $appointment->patient;
        $doctor = $appointment->doctor;

        if ($recipient === 'patient') {
            $greeting = "Dear {$patient->user->name},";
            $message = "Your appointment has been cancelled.";
        } else {
            $greeting = "Dear Dr. {$doctor->user->name},";
            $message = "An appointment has been cancelled.";
        }

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #ef4444; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Appointment Cancelled</h1>
                </div>
                <div class='content'>
                    <p>{$greeting}</p>
                    <p>{$message}</p>
                    <p>If you have any questions, please contact us.</p>
                    <p>Best regards,<br><strong>DocTime Team</strong></p>
                </div>
            </div>
        </body>
        </html>";
    }

    private function getAppointmentCancelledText($appointment, $recipient = 'patient')
    {
        $patient = $appointment->patient;
        $doctor = $appointment->doctor;

        if ($recipient === 'patient') {
            $greeting = "Dear {$patient->user->name},";
            $message = "Your appointment has been cancelled.";
        } else {
            $greeting = "Dear Dr. {$doctor->user->name},";
            $message = "An appointment has been cancelled.";
        }

        return "{$greeting}

{$message}

If you have any questions, please contact us.

Best regards,
DocTime Team";
    }
}