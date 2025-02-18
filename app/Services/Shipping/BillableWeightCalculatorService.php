<?php
declare(strict_types=1);

namespace App\Services\Shipping;


class BillableWeightCalculatorService
{
    public function calculate(
        PackageDimensions $packageDimensions,
        Weight $weight,
        DimDivisor $dimDivisor): int
    {
        $dimWeight = (int) round($packageDimensions->width * $packageDimensions->height * $packageDimensions->length / $dimDivisor->value);

        return max($weight->value, $dimWeight);
    }
}
