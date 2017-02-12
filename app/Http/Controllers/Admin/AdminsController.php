<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function show()
    {
        $administrators = User::where('is_admin', true)->get();
        $users = User::where('is_admin', false)->get();
        return view('admin.admins', compact('administrators', 'users'));
    }

    public function add(Request $request)
    {
        $this->validate($request, [
        'user_id' => 'required|exists:users,id',
    ]);
    User::find($request->input('user_id'))->update(['is_admin' => true]);

        return redirect()->back();
    }

    public function delete($user_id)
    {
        $user = User::findOrFail($user_id)->update(['is_admin' => false]);

        return redirect()->back();
    }
}
