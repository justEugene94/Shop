<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NovaPoshta\GetWarehousesRequest;
use Daaner\NovaPoshta\Models\Address;
use Illuminate\Http\Response;

class NovaPoshtaController extends Controller
{
    /**
     * @param GetWarehousesRequest $request
     *
     * @return Response
     */
    public function getWarehouses(GetWarehousesRequest $request)
    {
        $address = new Address;
        $warehouses = $address->getWarehouses($request->city);

        return response($warehouses, 200);
    }
}
