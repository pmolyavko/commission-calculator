<?php
declare(strict_types=1);

namespace App\Tests;

use App\Application\CommissionCalculator\CommissionCalculator;
use App\Application\CommissionCalculator\Transaction;
use App\Infrastructure\BinProvider;
use App\Infrastructure\RateProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommissionCalculatorTest extends KernelTestCase
{
    public function test_euro_currency_is_eu()
    {
        $mockTransaction = $this->getMockBuilder(Transaction::class)
            ->getMock();
        $mockTransaction->currency = 'EUR';
        $mockTransaction->amount = 100;

        $mockBinProvider = $this->getMockBuilder(BinProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockBinProvider->method('getCountryIsoCodeByBin')->willReturn('DE');

        $mockRateProvider = $this->getMockBuilder(RateProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockRateProvider->method('getRateByCurrency')->willReturn('0');

        $commissionCalculator = new CommissionCalculator($mockBinProvider, $mockRateProvider);

        $expectedResult = 1;
        $this->assertEquals($expectedResult, $commissionCalculator->calculate($mockTransaction));
    }

    public function test_euro_currency_not_eu()
    {
        $mockTransaction = $this->getMockBuilder(Transaction::class)
            ->getMock();
        $mockTransaction->currency = 'EUR';
        $mockTransaction->amount = 100;

        $mockBinProvider = $this->getMockBuilder(BinProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockBinProvider->method('getCountryIsoCodeByBin')->willReturn('US');

        $mockRateProvider = $this->getMockBuilder(RateProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockRateProvider->method('getRateByCurrency')->willReturn('0');

        $commissionCalculator = new CommissionCalculator($mockBinProvider, $mockRateProvider);

        $expectedResult = 2;
        $this->assertEquals($expectedResult, $commissionCalculator->calculate($mockTransaction));
    }

    public function test_not_euro_currency_is_eu()
    {
        $mockTransaction = $this->getMockBuilder(Transaction::class)
            ->getMock();
        $mockTransaction->currency = 'USD';
        $mockTransaction->amount = 50;

        $mockBinProvider = $this->getMockBuilder(BinProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockBinProvider->method('getCountryIsoCodeByBin')->willReturn('LT');

        $mockRateProvider = $this->getMockBuilder(RateProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockRateProvider->method('getRateByCurrency')->willReturn('0.93');

        $commissionCalculator = new CommissionCalculator($mockBinProvider, $mockRateProvider);

        $expectedResult = 0.54;
        $this->assertEquals($expectedResult, $commissionCalculator->calculate($mockTransaction));
    }

    public function test_not_euro_currency_not_eu()
    {
        $mockTransaction = $this->getMockBuilder(Transaction::class)
            ->getMock();
        $mockTransaction->currency = 'USD';
        $mockTransaction->amount = 50;

        $mockBinProvider = $this->getMockBuilder(BinProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockBinProvider->method('getCountryIsoCodeByBin')->willReturn('US');

        $mockRateProvider = $this->getMockBuilder(RateProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockRateProvider->method('getRateByCurrency')->willReturn('0.93');

        $commissionCalculator = new CommissionCalculator($mockBinProvider, $mockRateProvider);

        $expectedResult = 1.08;
        $this->assertEquals($expectedResult, $commissionCalculator->calculate($mockTransaction));
    }
}