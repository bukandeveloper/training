<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Response;

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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) {
        // If unauthorized user attempts to access links without login
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // If unauthorized user attempts to access admin links without login, prompts to admin login
        if (in_array('admin', $exception->guards())) {
            return redirect()->guest(route('auth.admin.login'));
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Overrides the default function, render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
        // handler for guard session check
        if ($exception instanceof AuthenticationException) {
           return $this->unauthenticated($request, $exception);
        }

        //if env APP_DEBUG = false show customize screen
        // laravel validation return severity error as exceptions
        // but those severity error no need to reported except the fatal error exception
        if (env("APP_DEBUG") == true) {
            // Redirect to Top Page when User access API with token and get exception Method Not Allowed
            if($request->is('api/*') && $exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
                return redirect('/');
            }
            else if($this->shouldReport($exception) == true) {
                return redirect()->route('500');
            }else if($this->isHttpException($exception)){
                if ($exception->getStatusCode() == "500") {
                    // return response()->view('frontend.500.index');
                    return redirect()->route('500');
                }
                else if ($exception->getStatusCode() == "404") {
                    // return response()->view('frontend.404.index');
                    return redirect()->route('404');
                }
            }
            else {
                return parent::render($request, $exception);
            }
        }

        //if env APP_DEBUG != false show error detail
        return parent::render($request, $exception);
    }
}
