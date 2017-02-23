<?php

namespace App\Http\Controllers;

use App\Category;
use App\Mail\TicketCreated;
use App\Ticket;
use App\Traits\BBCodeTrait;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketsController extends Controller
{
    use BBCodeTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $categories = Category::all();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required',
        ]);
        $ticket = new Ticket([
            'title'        => $request->input('title'),
            'user_id'      => Auth::user()->id,
            'ticket_id'    => strtoupper(str_random(10)),
            'category_id'  => $request->input('category'),
            'priority'     => $request->input('priority'),
            'message'      => $this->bbcode(htmlspecialchars($request->input('message'))),
        ]);

        $ticket->save();

        Mail::to(Auth::user()->email)->send(new TicketCreated(Auth::user(), $ticket));

        return redirect()->to('tickets/'.$ticket->ticket_id)->with('status', "A ticket with ID: #$ticket->ticket_id has been opened.");
    }

    public function userTickets()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
        $categories = Category::all();

        return view('tickets.user_tickets', compact('tickets', 'categories'));
    }

    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $comments = $ticket->comments;

        $category = $ticket->category;

        return view('tickets.show', compact('ticket', 'category', 'comments'));
    }
}
