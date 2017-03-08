<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class SessionsController extends Controller
{
    public function create()
    {
      return view('sessions.create');
    }

    public function store(Request $request)
    {
      $this->validate($request, [
        'email' => 'required|email|max:255',
        'password' => 'required'
      ]);

      $credentials = [
        'email' => $request->email,
        'password' => $request->password
      ];

      if (Auth::attempt($credentials, $request->has('remember'))) {
        //succeed
        session()->flash('success', 'welcome back!');
        return redirect()->route('users.show', [Auth::user()]);
      } else {
        //fail
        session()->flash('danger', 'sorry, your eamil or password is wrong!');
        return redirect()->back();
      }

    }

    public function destroy()
    {
      Auth::logout();
      session()->flash('success', 'logout succeed!');
      return redirect('login');
    }
}
