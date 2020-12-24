<?php

declare(strict_types=1);

namespace App\Controller;

use App\Context\Shared\Application\Bus\Command\ICommandBus;
use App\Context\Shared\Domain\Error\ApplicationError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SendOrderToKitchen extends AbstractController
{
    /**
     * @Route("/order/{id}/send_to_kitchen", name="order_send_to_kitchen")
     * @param $id
     * @param ICommandBus $commandBus
     * @return JsonResponse
     * @throws ApplicationError
     */
    public function __invoke($id, ICommandBus $commandBus)
    {
        $commandBus->dispatch(new \App\Context\OrderManagement\Application\Command\SendOrderToKitchen($id));

        return $this->json('ok');
    }
}