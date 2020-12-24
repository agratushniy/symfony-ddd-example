<?php

declare(strict_types=1);

namespace App\Context\Marketing\Application;

interface INotifySender
{
    public function sendNotify($someData): void;
}