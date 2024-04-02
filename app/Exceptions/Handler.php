<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Inertia\Inertia;

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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        try {
            $response = parent::render($request, $e);

            switch ($response->status()) {
                case 404:
                    return Inertia::render('Errors/NotFound')
                        ->toResponse($request)
                        ->setStatusCode($response->status());

                case 403:
                    return Inertia::render('Errors/NotAuthorized')
                        ->toResponse($request)
                        ->setStatusCode($response->status());

/*                 case 500:
                    return Inertia::render('Errors/ServerError')
                        ->toResponse($request)
                        ->setStatusCode($response->status()); */

                default:
                    return $response;
            }
        } catch (Throwable $exception) {
            return parent::render($request, $exception);
        }
    }

}
