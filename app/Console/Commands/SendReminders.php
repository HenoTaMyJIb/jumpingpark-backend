<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use DB;
use Carbon\Carbon;
use Mail;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jp:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reservation reminders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reservations = DB::table('onv8_ea_appointments')
            ->join('onv8_ea_services', 'onv8_ea_services.id', '=', 'onv8_ea_appointments.service')
            ->where('date', Carbon::today()->add(1, 'day'))
            ->select('onv8_ea_services.id', 'onv8_ea_services.name', 'onv8_ea_appointments.date', 'onv8_ea_appointments.start')
            ->get();

        foreach ($reservations as $reservation) {
            Log::info($reservation);
            $email = DB::table('onv8_ea_fields')->select('value')
            ->where('app_id', $reservation->id)
            ->where('field_id', 1)
            ->first();
            Log::info($email);
            $date = Carbon::parse($reservation->date . ' ' . $reservation->time)->format('d.M.Y H:i');
            Log::info($date);
            // Mail::to($reservation['email'])->send(new ReservationReminder($reservation->name, $date));
        }
    }
}
