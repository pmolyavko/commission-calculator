<?php

namespace App\Application\CommissionCalculator;

enum CountryIsoCodeEnum: string
{
    case AT = 'AT';
    case BE = 'BE';
    case BG = 'BG';
    case CY = 'CY';
    case CZ = 'CZ';
    case DE = 'DE';
    case DK = 'DK';
    case EE = 'EE';
    case ES = 'ES';
    case FI = 'FI';
    case FR = 'FR';
    case GR = 'GR';
    case HR = 'HR';
    case HU = 'HU';
    case IE = 'IE';
    case IT = 'IT';
    case LT = 'LT';
    case LU = 'LU';
    case LV = 'LV';
    case MT = 'MT';
    case NL = 'NL';
    case PO = 'PO';
    case PT = 'PT';
    case RO = 'RO';
    case SE = 'SE';
    case SI = 'SI';
    case SK = 'SK';

    public static function isEu(string $countryIso): bool
    {
        if (in_array($countryIso, array_column(self::cases(), 'value'))) {
            return true;
        }

        return false;
    }
}