<?php
declare(strict_types=1);

namespace App\Application\CommissionCalculator;

class Transaction
{
    public string $bin = '';

    public float $amount = 0.00;

    public string $currency = '';

    public static function create(array $data): self
    {
        $result = new self();
        $result->bin = $data['bin'];
        $result->amount = (float)$data['amount'];
        $result->currency = $data['currency'];

        return $result;
    }
}