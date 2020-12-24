<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Context\Kitchen\Application\Command\CompleteCookingDish;
use App\Context\Kitchen\Application\Query\Dto\OrderOnKitchenDto;
use App\Context\Kitchen\Application\Query\GetAllOrdersOnKitchen;
use App\Context\Marketing\Application\INotifySender;
use App\Context\OrderManagement\Application\Command\SendOrderToKitchen;
use App\Context\OrderManagement\Application\Query\Dto\OrderDto;
use App\Context\OrderManagement\Application\Query\GetAllOrders;
use App\Context\Shared\Application\Bus\Command\ICommandBus;
use App\Context\Shared\Application\Bus\Query\IQueryBus;
use App\DataFixtures\OrderFixture;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Doctrine\Bundle\FixturesBundle\Purger\ORMPurgerFactory;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class Order implements Context
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var ICommandBus
     */
    private ICommandBus $commandBus;
    /**
     * @var IQueryBus
     */
    private IQueryBus $queryBus;
    /**
     * @var INotifySender
     */
    private INotifySender $notifySender;

    public function __construct(
        EntityManagerInterface $entityManager,
        ICommandBus $commandBus,
        IQueryBus $queryBus,
        INotifySender $notifySender
    ) {
        $this->entityManager = $entityManager;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->notifySender = $notifySender;
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenario(BeforeScenarioScope $scope)
    {
        $factory = new ORMPurgerFactory();
        $purger = $factory->createForEntityManager(null, $this->entityManager);
        $purger->purge();
    }

    /**
     * @When /^Оператор отправляет заказ на кухню$/
     */
    public function операторОтправляетЗаказНаКухню()
    {
        /**
         * @var OrderDto[] $orders
         */
        $orders = $this->queryBus->ask(new GetAllOrders());

        $sendOrderToTheKitchen = new SendOrderToKitchen($orders[0]->id);
        $this->commandBus->dispatch($sendOrderToTheKitchen);
    }

    /**
     * @Then /^Блюда на кухне созданы$/
     */
    public function блюдаНаКухнеСозданы()
    {
        $kitchenOrders = $this->queryBus->ask(new GetAllOrdersOnKitchen());
        TestCase::assertCount(1, $kitchenOrders);
    }

    /**
     * @Given /^Тестовый заказ создан$/
     */
    public function тестовыйЗаказСоздан()
    {
        $orderFixture = new OrderFixture();
        $orderFixture->load($this->entityManager);
    }

    /**
     * @When /^Повар приготовил все блюда$/
     */
    public function поварПриготовилВсеБлюда()
    {
        /**
         * @var OrderOnKitchenDto[] $kitchenOrders
         */
        $kitchenOrders = $this->queryBus->ask(new GetAllOrdersOnKitchen());
        $dishes = $kitchenOrders[0]->dishes;
        $orderId = $kitchenOrders[0]->id;

        foreach ($dishes as $dish) {
            $this->commandBus->dispatch(new CompleteCookingDish($orderId, $dish->id));
        }
    }

    /**
     * @Then /^Заказ переходит в статус "([^"]*)"$/
     */
    public function заказПереходитВСтатус($arg1)
    {
        /**
         * @var OrderDto[] $orders
         */
        $orders = $this->queryBus->ask(new GetAllOrders());
        TestCase::assertEquals('cooked', $orders[0]->status);
    }

    /**
     * @Then /^Уведомления отправлены$/
     */
    public function уведомленияОтправлены()
    {
        TestCase::assertCount(2, $this->notifySender->data());
    }
}