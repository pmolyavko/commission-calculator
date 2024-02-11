<?php

namespace App\Application\CommissionCalculator;

interface RateProviderInterface
{
    public function getRateByCurrency(string $currency): string;
}