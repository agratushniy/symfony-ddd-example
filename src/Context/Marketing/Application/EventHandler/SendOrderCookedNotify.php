<?php

declare(strict_types=1);

namespace App\Context\Marketing\Application\EventHandler;

use App\Context\Kitchen\Domain\Event\OrderCookedOnKitchen;
use App\Context\Marketing\Application\INotifySender;
use App\Context\Shared\Application\IEventHandler;
use App\Context\Shared\Domain\Event;

class SendOrderCookedNotify implements IEventHandler
{
    /**
     * @var INotifySender
     */
    private INotifySender $notifySender;

    public function __construct(INotifySender $notifySender)
    {
        $this->notifySender = $notifySender;
    }

    public function __invoke(Event $event)
    {
        $this->notifySender->sendNotify('какие-то данные');
    }
}