<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDirtyWord
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
        $dirtyWords = [
            'apple',
            'orange'
        ];
        $parameters = $request->all();
        foreach ($parameters as $key => $value) {
            if ($key == 'content') {
                foreach ($dirtyWords as $dirtyWord) {
                    if (strpos($value, $dirtyWord)) {
                        return response('dirty!', 400);
                    }
                }
            }
        }

        return $next($request);
    }
}
