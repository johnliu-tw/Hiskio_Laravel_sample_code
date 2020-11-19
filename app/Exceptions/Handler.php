<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;
use App\Models\LogError;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (\Exception $exception) {
            $user = auth()->user();
            LogError::create([
                'user_id'    => $user ? $user->id : 0,
                'message'   => $exception->getMessage(),
                'exception' => get_class($exception),
                'line'      => $exception->getLine(),
                'trace'     => collect($exception->getTrace())->map(function ($trace) {
                    return Arr::except($trace, ['args']);
                })->all(),
                'method'      => request()->getMethod(),
                'params'      => request()->all(),
                'uri'         => request()->getPathInfo(),
                'user_agent'  => request()->userAgent(),
                'header'      => request()->headers->all()
            ]);
        });

        $this->renderable(function (\Exception $e) {
            // return response()->view('error', [], 500);
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json('Unauthenticated', 401);
    }
}
