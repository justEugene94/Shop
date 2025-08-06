<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NovaPoshta\GetCitiesRequest;
use App\Http\Requests\Api\NovaPoshta\GetWarehousesRequest;
use App\Http\Responses\Api\Response;
use Daaner\NovaPoshta\Models\Address;

class NovaPoshtaController extends Controller
{
    protected $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @param GetCitiesRequest $request
     *
     * @return Response
     */
    public function getCities(GetCitiesRequest $request): Response
    {
        $cities = $this->address->getCities($request->getCity(), true);

        return Response::make($cities['result']);
    }

    /**
     * @param GetWarehousesRequest $request
     *
     * @return Response
     */
    public function getWarehouses(GetWarehousesRequest $request): Response
    {
        $warehouses = $this->address->getWarehouses($request->getCity());

        return Response::make($warehouses['result']);
    }
}
