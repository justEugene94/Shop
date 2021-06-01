<?php


namespace App\Http\Responses\Api;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


class Response implements Responsable
{
    /**
     * @var mixed|null
     */
    protected $data;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var mixed
     */
    protected $pagination;

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var mixed
     */
    protected $validation;

    /**
     * @var array
     */
    protected $backtrace;

    /**
     * Response constructor.
     *
     * @param mixed|null $data
     * @param int $status
     * @param array $headers
     */
    public function __construct($data = null, int $status = 200, array $headers = [])
    {
        $this->data = $data;
        $this->status = $status;
        $this->headers = $headers;
    }

    /**
     * @param null $data
     * @param int $status
     * @param array $headers
     *
     * @return static
     */
    public static function make($data = null, int $status = 200, array $headers = []): self
    {
        return new static($data, $status, $headers);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $data = [];

        if ($this->data instanceof ResourceCollection) {
            $this->pagination = (new PaginatedResourceResponse($this->data))->getPagination($request);
        }

        if ($this->data instanceof JsonResource) {
            $this->data = array_replace(
                $this->data->resolve($request),
                $this->data->with($request),
                $this->data->additional
            );
        }

        if ($this->status === 200) {
            $data['result'] = $this->data;

            if (!empty($this->pagination)) {
                $data['pagination'] = $this->pagination;
            }
        }

        if (!empty($this->messages)) {
            $data['messages'] = $this->messages;
        }

        if (!empty($this->validation)) {
            $data['validation'] = $this->validation;
        }

        if (!empty($this->backtrace)) {
            $data['backtrace'] = $this->backtrace;
        }

        return new JsonResponse($data, $this->status, $this->headers);
    }

    /**
     * @param string $text
     * @param int $code
     *
     * @return $this
     */
    public function addErrorMessage(string $text, int $code): Response
    {
        $message = [
            'severity' => 'error',
            'text' => $text,
            'code' => $code
        ];

        $this->messages[] = $message;
        $this->status = $code;

        return $this;
    }

    /**
     * @param string $text
     * @param int $code
     *
     * @return $this
     */
    public function addSuccessMessage(string $text, int $code): Response
    {
        $message = [
            'severity' => 'success',
            'text' => $text,
            'code' => $code
        ];

        $this->messages[] = $message;
        $this->status = $code;

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setValidation(array $fields): Response
    {
        $this->validation = $fields;

        return $this;
    }

    /**
     * @param array $backtrace
     * @return $this
     */
    public function setBacktrace(array $backtrace): Response
    {
        $this->backtrace = $backtrace;

        return $this;
    }
}
