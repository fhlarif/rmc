<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Cas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

       // dd($request);
         /* For CAS */
         $cas = cas()->getAttributes();
         $user = User::where('userId', $request->session()->get('cas_user'))->first();
       // dd($user);
         /* Register first time user */
         if (!$user) {
           DB::table('users')->insert([
                 'name' => $cas['name'],
                 'email' =>  $cas['email'],
                 'password' =>  'zaNLNE5eqtAHcYZg',
                 'userId' =>  $cas['userId'],
                 'staffId' =>  $cas['staffId'],
                 'created_at' => Carbon::now()
             ]);
         }

        // $user = User::latest()->first();

        /* Check Role */
         //dd($user, $request->session());
        //  if($user->role !=='admin'){
        //      abort(403, 'Unauthorized action.');
        //  }else{
        //      return $next($request);
        //  }

         return $next($request);

    }
}
