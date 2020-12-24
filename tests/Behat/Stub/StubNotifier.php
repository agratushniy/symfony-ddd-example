<?php

declare(strict_types=1);

namespace App\Tests\Behat\Stub;

use App\Context\Marketing\Application\INotifySender;

class StubNotifier implements INotifySender
{
    private $data = [];

    public function sendNotify($someData): void
    {
        $this->data[] = $someData;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }
}