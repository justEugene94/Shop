<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Daaner\NovaPoshta\Models\Address;

class NovaPoshtaTest extends TestCase
{
    protected $city = "Київ";

    public function testGetCitiesWithoutCityReturnsValidationError()
    {
        $response = $this->json('GET', '/api/nova-poshta/cities');

        $response->assertStatus(422)
        ->assertJsonStructure(['messages', 'validation']);
    }

    public function testGetCitiesReturnsMockedCities()
    {
        $this->mockAddressGetCities();

        $response = $this->json('GET', '/api/nova-poshta/cities', ['city' => $this->city]);

        $response->assertSuccessful()
            ->assertJsonStructure(['result'])
            ->assertJsonFragment(['Ref' => '1', 'DescriptionUk' => 'Київ', 'DescriptionRu' => 'Киев']);
    }

    public function testGetWarehousesWithoutCityReturnsValidationError()
    {
        $response = $this->json('GET', '/api/nova-poshta/warehouses');

        $response->assertStatus(422)
            ->assertJsonStructure(['messages', 'validation']);
    }

    public function testGetWarehousesReturnsMockedWarehouses()
    {
        $this->mockAddressGetWarehouses();

        $response = $this->json('GET', '/api/nova-poshta/warehouses', ['city' => $this->city]);

        $response->assertSuccessful()
            ->assertJsonStructure(['result'])
            ->assertJsonCount(2, 'result')
            ->assertJsonFragment([
                'Ref' => '1',
                'DescriptionUk' => 'Відділення №1: вул. Пирогівський Шлях, 135',
                'DescriptionRu' => 'Отделение №1: ул. Пирогівський Шлях, 135'
            ])
            ->assertJsonFragment([
                'Ref' => '3',
                'DescriptionUk' => 'Відділення №3: вул. Слобожанська, 13',
                'DescriptionRu' => 'Отделение №3: ул. Слобожанская, 13'
            ]);
    }

    protected function mockAddressGetCities(array $response = null)
    {
        $this->mock(Address::class, function ($mock) use ($response) {
            $mock->shouldReceive('getCities')
                ->with($this->city, true)
                ->andReturn($response ?? [
                    'result' => [
                        ['Ref' => '1', 'DescriptionUk' => 'Київ', 'DescriptionRu' => 'Киев'],
                    ]
                ]);
        });
    }

    protected function mockAddressGetWarehouses(array $response = null)
    {
        $this->mock(Address::class, function ($mock) use ($response) {
            $mock->shouldReceive('getWarehouses')
                ->with($this->city)
                ->andReturn($response ?? [
                    'result' => [
                        [
                            'Ref' => '1',
                            'DescriptionUk' => 'Відділення №1: вул. Пирогівський Шлях, 135',
                            'DescriptionRu' => 'Отделение №1: ул. Пирогівський Шлях, 135'
                        ],
                        [
                            'Ref' => '3',
                            'DescriptionUk' => 'Відділення №3: вул. Слобожанська, 13',
                            'DescriptionRu' => 'Отделение №3: ул. Слобожанская, 13'
                        ],
                    ]
                ]);
        });
    }
}
