<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Auth;
use Alert;

class Role
{
    /**
        * Handle an incoming request.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \Closure  $next
        *
        * @return mixed
        */
       public function __construct(Request $request)
       {
           $this->req = $request;
       }

    public function handle($request, Closure $next, $role)
    {
        // dd(auth()->user()->is_active);
        if (auth()->user()) {
            if (auth()->user()->is_active == 1) {
                if (auth()->user()->role) {
                    $level = auth()->user()->role;
                } else {
                    Session::put('ss_status_user', 'naktif');
                    $level = 'no-access';

                    Auth::logout();
                    // return redirect('non-active');
                    Alert::error('Akses ditolak')->persistent('Ok');
                    return redirect()->route('login');
                }
            } else {
                Session::put('ss_status_user', 'naktif');
                $level = 'no-access';

                Auth::logout();
                // return redirect('non-active');
                Alert::error('User tidak aktif')->persistent('Ok');
                return redirect()->route('login');
            }
        } else {
            $level = 'no-access';

            Auth::logout();
            // return redirect('login');
            Alert::error('Silahkan Login')->persistent('Ok');
            return redirect()->route('login');
        }
        $roles = explode('_', $role);
        $x = 0;
        foreach ($roles as $r) {
            if ($level == $r) {
                $x = 1;
            }
        }

        if ($x == 1) {
            Session::put('ss_nama', auth()->user()->name);
            Session::put('ss_iduser', auth()->user()->id);
            Session::put('ss_role', auth()->user()->role);
            Session::put('ss_unit', auth()->user()->unit);

            return $next($request);
        }

        Auth::logout();
        Alert::error('Akses ditolak')->persistent('Ok');
        return redirect('login');
        // return response('Unauthorized.', 401);
    }
    //  public function handle($request, Closure $next, $role)
    //  {
    //      if (\Auth::user()->can(trim($role).'-access')) {
    //          return $next($request);
    //      }

    //      return response('Unauthorized.', 401);
    //  }
}
