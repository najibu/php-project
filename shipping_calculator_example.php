<?php
declare(strict_types=1);

use App\Services\Shipping\Weight;
use App\Services\Shipping\DimDivisor;
use App\Services\Shipping\PackageDimensions;
use App\Services\Shipping\BillableWeightCalculatorService;

require __DIR__ . '/vendor/autoload.php';

// test with 9 = 9 and 0 = fail
$package = [
    'weight' => 0,
    'dimensions' => [
        'width' => 9,
        'length' => 15,
        'height' => 7,
    ],
];

$packageDimenisions = new PackageDimensions(
    $package['dimensions']['width'],
    $package['dimensions']['height'],
    $package['dimensions']['length']
);

$billableWeightService = new BillableWeightCalculatorService();
$widerPackageDimensions = $packageDimenisions->increaseWidth(10);
$weigth = new Weight($package['weight']);

$billableWeight = $billableWeightService->calculate(
    $packageDimenisions,
    $weigth,
    DimDivisor::FEDEX
);

$widerPackagebillableWeight = $billableWeightService->calculate(
    $widerPackageDimensions,
    $weigth,
    DimDivisor::FEDEX
);

echo $billableWeight . ' lbs' . PHP_EOL; // 7 lbs
echo $widerPackagebillableWeight . ' lbs' . PHP_EOL; // 14 lbs
