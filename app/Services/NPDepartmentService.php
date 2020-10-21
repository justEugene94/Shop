<?php


namespace App\Services;


use App\Models\Customer;
use App\Models\NPDepartment;
use Daaner\NovaPoshta\Models\Address;

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
    public function create(Customer $customer, string $city, string $np_json): NPDepartment
    {
        $arrayNP = json_decode($np_json, true);

        $city = $this->cityService->getOrCreate($city, $arrayNP['CityRef']);

        $department = new NPDepartment([
            'np_id'      => $arrayNP['Ref'],
            'department' => $arrayNP['DescriptionRu'],
        ]);

        $city->npDepartments()->save($department);

        $customer->npDepartments()->attach($department->id);

        return $department;
    }
}
