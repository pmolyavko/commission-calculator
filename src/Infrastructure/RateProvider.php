<?php

namespace App\Infrastructure;

use App\Application\CommissionCalculator\RateProviderInterface;

class RateProvider implements RateProviderInterface
{
    public function getRateByCurrency(string $currency): string
    {
        //Here may be api request to any rates service instead of using file
        $data = json_decode(file_get_contents(__DIR__ . '/rates.json'), true);

        if (array_key_exists($currency, $data)) {
            return $data[$currency];
        }

        throw new \Exception("Invalid currency ($currency) provided");
    }
}