<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $service;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($service, $date)
    {
        $this->service = $service;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('reservation-reminder')->subject('Trefoil Jumping Park | Homse ürituse info');
    }
}
