<?php

namespace App\Services;

use Carbon\Carbon;

class WeatherService
{

    private $daysCount = 5;
    private $baseUrl = 'https://api.openweathermap.org/data/2.5/forecast';
    const APPID = 'daf02c61391f9f612411ad0bd83240ed';

    public function forecast($city)
    {
        $request_url = "{$this->baseUrl}/daily?q={$city}&appid=".self::APPID."&cnt={$this->daysCount}";
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

            switch($forecast->weather[0]->main){
                case 'Rain':
                        $dailyForecast['weather']['image'] = '';
                        break;
                case 'Clear':
                        $dailyForecast['weather']['image'] = '';
                        break;
                case 'Clouds':
                        $dailyForecast['weather']['image'] = '';
                        break;
            }

            $parsedWeather['forecasts'][] = $dailyForecast;
        }

        return $parsedWeather;
    }
}