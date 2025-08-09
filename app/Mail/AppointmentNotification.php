<?php

namespace App\Mail;

use App\Models\Appointments;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $type;

    /**
     * Create a new message instance.
     *
     * @param Appointments $appointment
     * @param string $type (new_request, confirmed, cancelled, reminder)
     */
    public function __construct(Appointments $appointment, string $type = 'new_request')
    {
        $this->appointment = $appointment;
        $this->type = $type;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->getSubject();
        $view = $this->getView();

        return $this->subject($subject)
                    ->view($view)
                    ->with([
                        'appointment' => $this->appointment,
                        'type' => $this->type,
                        'cancellationUrl' => $this->appointment->getCancellationUrl()
                    ]);
    }

    /**
     * Get email subject based on type
     */
    private function getSubject(): string
    {
        return match($this->type) {
            'new_request' => 'Nueva Solicitud de Cita - ' . $this->appointment->workshop->name,
            'confirmed' => 'Cita Confirmada - ' . $this->appointment->workshop->name,
            'cancelled' => 'Cita Cancelada - ' . $this->appointment->workshop->name,
            'reminder' => 'Recordatorio de Cita - ' . $this->appointment->workshop->name,
            default => 'Notificación de Cita - ' . $this->appointment->workshop->name
        };
    }

    /**
     * Get email view based on type
     */
    private function getView(): string
    {
        return match($this->type) {
            'new_request' => 'emails.appointment-new-request',
            'confirmed' => 'emails.appointment-confirmed',
            'cancelled' => 'emails.appointment-cancelled',
            'reminder' => 'emails.appointment-reminder',
            default => 'emails.appointment-notification'
        };
    }
}
