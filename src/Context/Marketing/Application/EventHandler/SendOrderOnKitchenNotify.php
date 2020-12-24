<?php

declare(strict_types=1);

namespace App\Context\Marketing\Application\EventHandler;

use App\Context\Kitchen\Domain\Event\OrderCreatedOnKitchen;
use App\Context\Marketing\Application\INotifySender;
use App\Context\Shared\Application\IEventHandler;

/**
 * Отправить уведомление, что заказ поступил на кухню
 */
class SendOrderOnKitchenNotify implements IEventHandler
{
    /**
     * @var INotifySender
     */
    private INotifySender $notifySender;

    public function __construct(INotifySender $notifySender)
    {
        $this->notifySender = $notifySender;
    }

    public function __invoke(OrderCreatedOnKitchen $event)
    {
        $this->notifySender->sendNotify('какие-то данные');
    }
}