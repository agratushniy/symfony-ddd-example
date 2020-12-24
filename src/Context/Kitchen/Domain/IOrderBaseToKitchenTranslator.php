<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Domain;

interface IOrderBaseToKitchenTranslator
{
    public function translate(string $baseOrderId): Order;
}