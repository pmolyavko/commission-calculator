<?php
declare(strict_types=1);

namespace App\Application\CommissionCalculator;

class CommissionCalculator implements CommissionCalculatorInterface
{
    const EU_COMMISSION = 0.01;
    const NOT_EU_COMMISSION = 0.02;

    public function __construct(
        private BinProviderInterface $binProvider,
        private RateProviderInterface $rateProvider
    )
    {
    }

    public function calculate(Transaction $transaction): int|float
    {
        $countryIso = $this->binProvider->getCountryIsoCodeByBin($transaction->bin);
        $rate = $this->rateProvider->getRateByCurrency($transaction->currency);

        if ($transaction->currency === 'EUR') {
            $result = $transaction->amount;
        } elseif($rate > 0) {
            $result = $transaction->amount / $rate;
        }

        return ceil(
            $result * (CountryIsoCodeEnum::isEu($countryIso) ? self::EU_COMMISSION : self::NOT_EU_COMMISSION) * 100
            ) / 100;
    }
}