<?php


namespace App\Services;


use App\Models\Customer;
use App\Models\NPDepartment;
use Daaner\NovaPoshta\Models\Address;
use Illuminate\Database\Eloquent\Model;

class NPDepartmentService
{
    /** @var CityService */
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * @param Customer $customer
     * @param string $city
     * @param string $np_json
     *
     * @return NPDepartment
     */
    public function firstOrCreate(Customer $customer, string $city, string $np_json): NPDepartment
    {
        $arrayNP = json_decode($np_json, true);

        $city = $this->cityService->firstOrCreate($arrayNP['CityRef'], $city);

        /** @var NPDepartment $department */
        $department = NPDepartment::query()->firstOrCreate([
            'city_id' => $city->id,
            'np_id' => $arrayNP['Ref'],
        ], [
            'city_id' => $city->id,
            'np_id' => $arrayNP['Ref'],
            'department' => $arrayNP['DescriptionRu'],
        ]);

        if (!$customer->npDepartments()->firstWhere('np_department_id', '=', $department->id))
        {
            $customer->npDepartments()->attach($department->id);
        }

        return $department;
    }
}
