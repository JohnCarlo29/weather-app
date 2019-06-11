<?php

namespace App\Services;

use Carbon\Carbon;

class WeatherService
{

    private $daysCount = 5;
    private $appUrl;
    private $appId;

    public function __construct()
    {
        $this->appUrl = env('OPEN_WEATHER_API_URL', 'https://api.openweathermap.org/data/2.5/forecast');
        $this->appId = env('OPEN_WEATHER_API_KEY', 'daf02c61391f9f612411ad0bd83240ed');
    }

    public function forecast($city)
    {
        $request_url ="{$this->appUrl}/daily?q={$city}&appid={$this->appId}&cnt={$this->daysCount}";

        $weather = $this->getForecast($request_url);

        return $this->parseWeather($weather);
        
    }

    private function getForecast($url)
    {
        return json_decode(file_get_contents($url));
    }

    private function parseWeather($cityWeather)
    {
        $parsedWeather = [
            'city' => $cityWeather->city->name,
            'forecasts' => []
        ];

        $dailyForecast = [];

        foreach($cityWeather->list as $forecast){
            $dailyForecast['date'] = Carbon::createFromTimestamp($forecast->dt)->toDateTimeString();
            $dailyForecast['weather']['type'] = $forecast->weather[0]->main;
            $dailyForecast['weather']['description'] = $forecast->weather[0]->description;
            $dailyForecast['weather']['temp']['max'] = number_format(($forecast->temp->max - 273.15), 2);
            $dailyForecast['weather']['temp']['min'] = number_format(($forecast->temp->min - 273.15), 2);

            $parsedWeather['forecasts'][] = $dailyForecast;
        }

        return $parsedWeather;
    }
}