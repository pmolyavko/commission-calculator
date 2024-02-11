<?php
declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\CommissionCalculator\BinProviderInterface;

class BinProvider implements BinProviderInterface
{
    public function getCountryIsoCodeByBin(string $bin): string
    {
        //Here may be api request to any bin service instead of using file
        $data = json_decode(file_get_contents(__DIR__ . '/bin.json'), true);
        if (array_key_exists($bin, $data)) {
            return $data[$bin];
        }

        throw new \Exception("Invalid bin ($bin) provided");
    }
}