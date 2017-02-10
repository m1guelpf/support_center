<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Ticket;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function tickets()
    {
        $tickets = Ticket::paginate(10);
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function changeStatus($ticket_id) // AppMailer $mailer
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        if ($ticket->status == 'Open') {
            $ticket->status = 'Closed';
        } elseif ($ticket->status == 'Closed') {
            $ticket->status = 'Open';
        }

        $ticket->save();

        $ticketOwner = $ticket->user;

    // $mailer->sendTicketStatusNotification($ticketOwner, $ticket);
    if ($ticket->status == 'Open') {
        return redirect()->back()->with('status', 'The ticket has been reopened.');
    } elseif ($ticket->status == 'Closed') {
        return redirect()->back()->with('status', 'The ticket has been closed.');
    }
    }
}
