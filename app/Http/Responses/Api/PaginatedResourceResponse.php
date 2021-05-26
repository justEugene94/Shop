<?php


namespace App\Http\Responses\Api;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse as BasePaginatedResourceResponse;

class PaginatedResourceResponse extends BasePaginatedResourceResponse
{
    /**
     * @param Request $request
     * @return array
     */
    public function getPagination(Request $request): array
    {
        return $this->paginationInformation($request);
    }
}
