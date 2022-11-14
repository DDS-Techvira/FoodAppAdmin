<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class checkPatientStatus
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
        if (Auth::guard('patient')->check()) {
            $staff = Auth::guard('patient')->user();
            if ($staff->status && $staff->tv  && $staff->sv && $staff->ev) {
                return $next($request);
            } else {
                return redirect()->route('patient.authorization');
            }
        }
        abort(403);
    }
}
