<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendDailyWithdrawals extends Mailable
{
    use Queueable, SerializesModels;

    public $withdrawals;
    public $date_formated;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($withdrawals, $date_formated)
    {
        $this->withdrawals = $withdrawals;
        $this->date_formated = $date_formated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.daily_withdrawals');
    }
}
