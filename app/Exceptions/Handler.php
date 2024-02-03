<?php

namespace App\Exceptions;

use App\Facades\Response;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response as ResponseMain;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register()
    {
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            $message = ResponseMain::$statusTexts[$statusCode];

            return Response::message($message)
                ->send($statusCode);
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));
            return Response::message('global.errors.not_found')
                ->send(ResponseMain::HTTP_NOT_FOUND);
        }

        if ($exception instanceof BadRequestException) {
            return Response::message($exception->getMessage())
                ->send(ResponseMain::HTTP_BAD_REQUEST);
        }

        if ($exception instanceof AuthorizationException) {
            return Response::message($exception->getMessage())
                ->send(ResponseMain::HTTP_FORBIDDEN);
        }

        if ($exception instanceof UnauthorizedException) {
            return Response::message($exception->getMessage())
                ->send(ResponseMain::HTTP_FORBIDDEN);
        }

        if ($exception instanceof AuthenticationException) {
            return Response::message($exception->getMessage())
                ->send(ResponseMain::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->errors()->messages();

            return Response::errors($errors)
                ->message($exception->getMessage())
                ->send(ResponseMain::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof ClientException) {
            $errors = $exception->getResponse()->getBody();
            $code = $exception->getCode();

            return Response::errors($errors)
                ->send($code);
        }

        if (env('APP_DEBUG', false)) {
            return parent::render($request, $exception);
        }

        return Response::message('Unexpected Error , try later please')
            ->send(ResponseMain::HTTP_INTERNAL_SERVER_ERROR);
    }
}
