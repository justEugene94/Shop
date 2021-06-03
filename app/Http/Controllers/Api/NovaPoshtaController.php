<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NovaPoshta\GetCitiesRequest;
use App\Http\Requests\Api\NovaPoshta\GetWarehousesRequest;
use App\Http\Responses\Api\Response;
use Daaner\NovaPoshta\Models\Address;

class NovaPoshtaController extends Controller
{
    /**
     * @param GetCitiesRequest $request
     *
     * @return Response
     */
    public function getCities(GetCitiesRequest $request): Response
    {
        $address = new Address;
        $cities = $address->getCities($request->getCity(), true);

        return Response::make($cities['result']);
    }

    /**
     * @param GetWarehousesRequest $request
     *
     * @return Response
     */
    public function getWarehouses(GetWarehousesRequest $request): Response
    {
        $address = new Address;
        $warehouses = $address->getWarehouses($request->getCity());

        return Response::make($warehouses['result']);
    }
}
