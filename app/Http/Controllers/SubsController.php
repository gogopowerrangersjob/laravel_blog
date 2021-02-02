<?php

namespace App\Http\Controllers;

use App\Subsription;
use App\Mail\SubscribeEmail;
use Illuminate\Http\Request;

class SubsController extends Controller
{
    public function subscribe(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|email|unique:subsriptions'
    	]);
    	
    	$subs = Subsription::add($request->get('email'));
        $subs->generateToken();

    	\Mail::to($subs)->send(new SubscribeEmail($subs));

    	return redirect()->back()->with('status', 'Проверьте вашу почту');
    }

    public function verify($token) {

        $subs = Subsription::where('token', $token)->firstOrFail();
        $subs->token = null;
        $subs->save();

        return redirect('/')->with('status', 'molodec, huec');
    }
}
