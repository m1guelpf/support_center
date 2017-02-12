<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Ticket;

class StatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Ticket $ticket)
    {
      $this->user = $user;
      $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.ticket_status')
                    ->with([
                        'ticket' => $this->ticket,
                        'user'   => $this->user,
                    ]);
    }
}
