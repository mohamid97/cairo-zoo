<?php

namespace App\Exceptions;

use App\Trait\ResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
class Handler extends ExceptionHandler
{

    use ResponseTrait;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {

            return $this->res(true , 'unauthenticated' , JsonResponse::HTTP_UNAUTHORIZED , 'You are not unauthenticated. Please log in to access this resource');
        }
        if ($exception instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
            return $this->res(false , 'Many Requests' , 429 , 'Too many requests, please slow down!');
        }





        return parent::render($request, $exception);
    }



}
