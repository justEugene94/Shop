<?php

namespace App\Exceptions;

use App\Http\Responses\Api\Response;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

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
     * @param  \Throwable  $e
     * @return void
     *
     * @throws \Exception|Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        $e = $this->prepareException($e);

        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $this->JsonResponse($request, $e);
    }

    /**
     * @param ValidationException $e
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request): \Symfony\Component\HttpFoundation\Response
    {
        if ($e->response) {
            return $e->response;
        }

        return Response::make()
            ->setValidation($e->errors())
            ->addErrorMessage($e->getMessage(), 422)
            ->toResponse($request);
    }

    /**
     * @param Request $request
     * @param \Exception $e
     * @return JsonResponse
     */
    protected function JsonResponse(Request $request, Exception $e): JsonResponse
    {
        $status = $this->isHttpException($e) ? $e->getStatusCode() : 500;
        $headers = $this->isHttpException($e) ? $e->getHeaders() : [];

        $response = Response::make(null, $status, $headers);

        if (config('app.debug')) {
            $response->setBacktrace($this->convertExceptionToArray($e));
        }

        return $response->addErrorMessage($e->getMessage(), $status)->toResponse($request);
    }
}
