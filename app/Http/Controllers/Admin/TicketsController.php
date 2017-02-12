<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Mail\StatusChanged;
use Illuminate\Support\Facades\Mail;
use App\Ticket;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function tickets($status = null)
    {
        if ($status == 'open') {
            $tickets = Ticket::where('status', 'Open')->paginate(10);
        } elseif ($status == 'closed') {
            $tickets = Ticket::where('status', 'Closed')->paginate(10);
        } else {
            $tickets = Ticket::paginate(10);
        }
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function changeStatus($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        if ($ticket->status == 'Open') {
            $ticket->status = 'Closed';
        } elseif ($ticket->status == 'Closed') {
            $ticket->status = 'Open';
        }

        $ticket->save();

    Mail::to($ticket->user->email)->send(new StatusChanged($ticket->user, $ticket));

    if ($ticket->status == 'Open') {
        return redirect()->back()->with('status', 'The ticket has been reopened.');
    } elseif ($ticket->status == 'Closed') {
        return redirect()->back()->with('status', 'The ticket has been closed.');
    }
    }
}
