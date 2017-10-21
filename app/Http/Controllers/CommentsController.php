<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Mail\TicketCommented;
use App\Ticket;
use App\Traits\BBCodeTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentsController extends Controller
{
    use BBCodeTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postComment(Request $request) // AppMailer $mailer
    {
        $this->validate($request, [
          'comment'   => 'required',
          'ticket_id' => 'required|exists:tickets,ticket_id',
        ]);

        $ticket = Ticket::where('ticket_id', $request->input('ticket_id'))->first();
        if (Auth::id() != $ticket->user_id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $comment = Comment::create([
          'ticket_id' => $ticket->id,
          'user_id'   => Auth::user()->id,
          'comment'   => $this->bbcode(htmlspecialchars($request->input('comment'))),
      ]);
        // send mail if the user commenting is not the ticket owner
        if ($comment->ticket->user->id != Auth::id()) {
            Mail::to($comment->ticket->user->email)->send(new TicketCommented($comment->ticket->user, $comment, $comment->ticket));
        }

        return redirect()->back()->with('status', 'Your comment has been submitted.');
    }
}
