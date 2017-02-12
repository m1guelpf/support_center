<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Ticket;
use App\User;
use App\Comment;

class TicketCommented extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $comment;
    public $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Comment $comment, Ticket $ticket)
    {
        $this->user = $user;
        $this->ticket = $ticket;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.ticket_comments')
                    ->with([
                        'ticket' => $this->ticket,
                        'user'   => $this->user,
                        'comment' => $this->comment,
                    ]);
    }
}
