<?php

namespace App\DataFixtures;

use App\Context\OrderManagement\Domain\Order;
use App\Context\OrderManagement\Domain\OrderId;
use App\Context\OrderManagement\Domain\LineItem;
use App\Context\OrderManagement\Domain\LineItemId;
use App\Context\OrderManagement\Domain\Quantity;
use App\Context\Shared\Domain\ValueObject\Money;
use App\Context\Shared\Domain\ValueObject\Title;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class OrderFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $itemsData = [
            [
                'title' => 'Пепперони',
                'price' => 350,
                'quantity' => 2
            ],
            [
                'title' => 'Четыре сыра',
                'price' => 300,
                'quantity' => 1
            ],
        ];


        $orderItems = new ArrayCollection();

        foreach ($itemsData as $data) {
            $orderItem = new LineItem(LineItemId::generateNext(), Title::create($data['title']),
                Money::fromRoubles($data['price']), Quantity::create($data['quantity']));

            $orderItems->add($orderItem);
        }

        $order = new Order(OrderId::generateNext(), $orderItems);
        $manager->persist($order);

        $manager->flush();
    }
}
