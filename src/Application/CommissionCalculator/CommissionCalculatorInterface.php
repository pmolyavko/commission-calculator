<?php

namespace App\Application\CommissionCalculator;

interface CommissionCalculatorInterface
{
    public function calculate(Transaction $transaction): int|float;
}