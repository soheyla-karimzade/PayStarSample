<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function ChangeCardNumber(){
       return view('change-card-number');
    }
    public function ChangeCardNumberUser(Request $request){
        DB::table('users')
            ->where(  'id',auth()->user()->id)
            ->update(['card_number'=>$request->request->get('card_number')]);

        Session::flash('message', 'your card number is changed');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('change.card.number');
    }
}
