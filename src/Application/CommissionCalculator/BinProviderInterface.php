<?php
namespace App\Application\CommissionCalculator;

interface BinProviderInterface
{
    public function getCountryIsoCodeByBin(string $bin): string;
}