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
     * @var int
     */
    protected $options;

    /**
     * @var mixed
     */
    protected $pagination;

    /**
     * Response constructor.
     *
     * @param mixed|null $data
     * @param int $status
     * @param array $headers
     * @param int $options
     */
    public function __construct($data = null, int $status = 200, array $headers = [], int $options = 0)
    {
        $this->data = $data;
        $this->status = $status;
        $this->headers = $headers;
        $this->options = $options;
    }

    /**
     * @param null $data
     * @param int $status
     * @param array $headers
     * @param int $options
     *
     * @return static
     */
    public static function make($data = null, int $status = 200, array $headers = [], int $options = 0): self
    {
        return new static($data, $status, $headers, $options);
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

        return new JsonResponse($data, $this->status, $this->headers, $this->options);
    }
}
