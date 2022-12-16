<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserCardNumber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!empty(auth()->user())){
            if($request->server->get('REQUEST_URI') !='/change-card-number-action'){
                if(empty(auth()->user()->card_number) ){
                    return response()->view('change-card-number');
                }
            }

        }
        return $next($request);
    }
}
