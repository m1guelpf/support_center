<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\User;

class DashboardController extends Controller
{
    public function index($indicator_period = 2)
    {
        $tickets_count = Ticket::count();
        $open_tickets_count = Ticket::where('status', 'Open')->count();
        $closed_tickets_count = Ticket::where('status', 'Closed')->count();
        // Per Category pagination
        $categories = Category::paginate(10, ['*'], 'cat_page');
        // Total tickets counter per category for google pie chart
        $categories_all = Category::all();
        $categories_share = [];
        foreach ($categories_all as $cat) {
            $categories_share[$cat->name] = $cat->tickets->count();
        }
        // Per User
        $users = User::paginate(10);
        if (request()->has('cat_page')) {
            $active_tab = 'cat';
        } elseif (request()->has('agents_page')) {
            $active_tab = 'agents';
        } elseif (request()->has('users_page')) {
            $active_tab = 'users';
        } else {
            $active_tab = 'cat';
        }

        return view(
            'admin.dashboard',
            compact(
                'open_tickets_count',
                'closed_tickets_count',
                'tickets_count',
                'categories',
                'users',
                'categories_share',
                'active_tab'
            ));
    }
}
