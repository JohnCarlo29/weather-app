<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\WeatherService;

class WeatherTest extends TestCase
{

    public function testGetCityForecasts()
    {

        $service = new WeatherService();
        $forecasts = $service->forecast('Tokyo');

        $this->assertArrayHasKey('city', $forecasts);
        $this->assertArrayHasKey('forecasts', $forecasts);
    }
}
