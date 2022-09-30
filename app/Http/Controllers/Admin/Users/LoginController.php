<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;


class LoginController extends Controller
{
    
  
    public function index(){
        return view('Admin.Users.Login',[
            'title' => 'Dang nhap he thong'
        ]);
    }
    public function store(Request $request){
       // dd($request->input());
      $this -> validate($request,[
        'email' => 'required|email:filter',
        'password' => 'required'
      ]);
      $credentials = [
        'email' => $request['email'],
        'password' => $request['password'],
    ];
    if (Auth::attempt($credentials,$request ->input('remember'))) {
      return redirect()->route('admin');
  }
  //$request->session()->flash('error', 'Task was successful!');
  Session::flash('error','Tai khoan hoac mat khau khong dung');
  return redirect() -> back();
}

}
