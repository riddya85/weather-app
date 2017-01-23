<?php

namespace App\Services;


class WeatherService
{
    private $APP_KEY;

    public $lat, $lng;

    public function __construct($APP_KEY) {
        $this->APP_KEY = $APP_KEY;
    }

    public function getData($lat, $lng) {

        $this->lat = $lat;
        $this->lng = $lng;

        $APP_KEY = $this->APP_KEY;

        $url = "https://api.darksky.net/forecast/".$APP_KEY."/".$lat.",".$lng;

        $info = file_get_contents($url);
        $info = json_decode($info);

        $currentForecast = $info->currently;
        
        $currentForecast->pressure = number_format($currentForecast->pressure,0);
        $currentForecast->humidity = $currentForecast->humidity*100;
        $currentForecast->windSpeed = number_format($currentForecast->windSpeed*0.277,1);
        $currentForecast->temperature = number_format(($currentForecast->temperature-32)*5/9,1);
        $currentForecast->apparentTemperature = number_format(($currentForecast->apparentTemperature-32)*5/9,1);

        $hourlyForecastItems = $info->hourly;

        $hourlyForecast = array();

        foreach ($hourlyForecastItems->data as $key => $item) {

            $item->temperature = number_format(($item->temperature-32)*5/9,1);
            $item->apparentTemperature = number_format(($item->apparentTemperature-32)*5/9,1);

            if ($key != 24) {
                array_push($hourlyForecast,$item);
            } else {
                break;
            }
        }

        $dailyForecastItems = $info->daily;

        $dailyForecast = array();

        foreach ($dailyForecastItems->data as $key => $item) {
            if ($key != 0 && $key < 4) {

                $item->pressure = number_format($item->pressure,0);
                $item->humidity = $item->humidity*100;
                $item->windSpeed = number_format($item->windSpeed*0.277,1);
                
                $item->temperatureMin = number_format(($item->temperatureMin-32)*5/9,1);
                $item->apparentTemperatureMin = number_format(($item->apparentTemperatureMin-32)*5/9,1);

                $item->temperatureMax = number_format(($item->temperatureMax-32)*5/9,1);
                $item->apparentTemperatureMax = number_format(($item->apparentTemperatureMax-32)*5/9,1);

                array_push($dailyForecast,$item);
            } elseif ($key > 0) {
                break;
            }
        }

        return ['currentForecast' => $currentForecast, 'hourlyForecast' => $hourlyForecast, 'dailyForecast' => $dailyForecast, 'summary' => $hourlyForecastItems->summary];
    }
    
    public function prepareChartData($hourlyForecast) {
        
        $timeLabels = array();
        $dataSet = array();
        $temperatures = array();
        $feelsLikeTemp = array();

        foreach ($hourlyForecast as $key => $item) {
            $timeLabels[] = date('H:i',$item->time);

            $temperatures[] = number_format(($item->temperature-32)*5/9,1);
            $feelsLikeTemp[] = number_format(($item->apparentTemperature-32)*5/9,1);
        }

        $dataSet[] = array('label'=>'Temparature','data'=>array($temperatures),'backgroundColor'=>'rgba(153,255,51,0.4)');
        $dataSet[] = array('label'=>'Feels like','data'=>array($feelsLikeTemp),'backgroundColor'=>'rgba(255,153,0,0.4)');

        return json_encode(array('data'=>$dataSet,'labels'=>$timeLabels));
    }
}
