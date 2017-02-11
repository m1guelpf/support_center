<?php

namespace App\Mail;

use App\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreated extends Mailable
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
        return $this->view('mail.ticket_info')
                    ->with([
                        'ticket' => $this->ticket,
                        'user'   => $this->user,
                    ]);
    }
}
