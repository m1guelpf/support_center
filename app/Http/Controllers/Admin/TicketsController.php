<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Ticket;
use App\Category;

class TicketsController extends Controller
{
  public function index()
  {
    $tickets = Ticket::paginate(10);
    $categories = Category::all();

    return view('tickets.index', compact('tickets', 'categories'));
  }

  public function close($ticket_id) // AppMailer $mailer
  {
    $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

    $ticket->status = 'Closed';

    $ticket->save();

    $ticketOwner = $ticket->user;

    // $mailer->sendTicketStatusNotification($ticketOwner, $ticket);

    return redirect()->back()->with("status", "The ticket has been closed.");
  }
}
