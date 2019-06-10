<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;

class WeatherController extends Controller
{
    
    private $service;

    public function __construct(WeatherService $weatherService)
    {
        $this->service = $weatherService;
    }

    public function index()
    {
        return view('weather.index');
    }

    public function forecast($city)
    {
        return $this->service->forecast($city);
    }
}
