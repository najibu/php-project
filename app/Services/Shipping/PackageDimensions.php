<?php
declare(strict_types=1);
namespace App\Services\Shipping;

class PackageDimensions
{
    public function __construct(public readonly int $width, public readonly int $height, public readonly int $length)
    {
        match (true) {
            $this->width <= 0 || $this->width > 80 => throw new \InvalidArgumentException("Invalid package width"),
            $this->height <= 0 || $this->height > 70 => throw new \InvalidArgumentException("Invalid package height"),
            $this->length <= 0 || $this->length > 120 => throw new \InvalidArgumentException("Invalid package length"),
            default => true
        };
    }

    public function increaseWidth(int $width): PackageDimensions
    {
        return new self($width + $this->width, $this->height, $this->length);
    }

    public function equalTo($packageDimension)
    {
        return $this->width === $packageDimension->width
        && $this->height === $packageDimension->height
        && $this->length === $packageDimension->length;
    }
}
