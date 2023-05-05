<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

  
    public function register()
    {
        $this->renderable(function (\Exception $e) {
            if ($e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException) {
                return redirect()->route('buyer-login');
            };
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $exception->redirectTo()
        ? redirect()->guest($exception->redirectTo())
        : custom_error(419, 'You are not authorized to login here');

    }
}
