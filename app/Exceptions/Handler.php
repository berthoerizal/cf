<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            // detect previous instance
            if ($exception->getPrevious() instanceof TokenExpiredException) {
                return response()->json(['error' => 'TOKEN_EXPIRED'], $exception->getStatusCode());
            } else if ($exception->getPrevious() instanceof TokenInvalidException) {
                return response()->json(['error' => 'TOKEN_INVALID'], $exception->getStatusCode());
            } else if ($exception->getPrevious() instanceof TokenBlacklistedException) {
                return response()->json(['error' => 'TOKEN_BLACKLISTED'], $exception->getStatusCode());
            } else {
                return response()->json(['error' => "UNAUTHORIZED_REQUEST"], 401);
            }
        }
        return parent::render($request, $exception);
    }
}
