<?php

namespace App\Console\Commands;

use App\Contracts\Services\AppointmentServiceInterface;
use App\Models\Appointments;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send appointment reminders for tomorrow';

    private AppointmentServiceInterface $appointmentService;

    public function __construct(AppointmentServiceInterface $appointmentService)
    {
        parent::__construct();
        $this->appointmentService = $appointmentService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending appointment reminders...');

        $tomorrow = Carbon::tomorrow();

        // Obtener citas confirmadas para mañana
        $appointments = Appointments::whereDate('appointment_date', $tomorrow)
                                   ->where('status', 'confirmed')
                                   ->get();

        $sentCount = 0;

        foreach ($appointments as $appointment) {
            try {
                $this->appointmentService->sendReminder($appointment->appointment_id);
                $sentCount++;

                $this->info("Reminder sent to: {$appointment->client_email}");
            } catch (\Exception $e) {
                $this->error("Failed to send reminder to {$appointment->client_email}: " . $e->getMessage());
            }
        }

        $this->info("Finished! Sent {$sentCount} appointment reminders.");

        return Command::SUCCESS;
    }
}
