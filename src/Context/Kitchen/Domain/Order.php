<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Domain;

use App\Context\Kitchen\Domain\Event\OrderCookedOnKitchen;
use App\Context\Kitchen\Domain\Event\OrderCreatedOnKitchen;
use App\Context\Shared\Domain\AggregateRoot;
use App\DDDDocs\Annotation\BusinessRule;
use App\DDDDocs\Annotation\Entity;
use Doctrine\Common\Collections\Collection;

/**
 * @Entity(name="Заказ", description="Заказ на кухне, с которым работают повора. Повар берет заказ в работу и по очереди готовит все блюда в заказе.")
 */
class Order extends AggregateRoot
{
    /**
     * @var Collection
     */
    private Collection $dishes;
    private bool $cooked;

    /**
     * Создать заказ
     * @param OrderId $id
     * @param Collection $dishes
     */
    public function __construct(OrderId $id, Collection $dishes)
    {
        $this->id = $id;
        $this->dishes = $dishes;
        $this->cooked = false;
        $this->record(new OrderCreatedOnKitchen($id->value()));
    }

    /**
     * @return Collection
     */
    public function dishes(): Collection
    {
        return $this->dishes;
    }

    /**
     * Приготовить блюдо
     * @param DishId $dishId
     */
    public function completeCookingDish(DishId $dishId): void
    {
        $filter = $this->dishes->filter(function (Dish $dish) use ($dishId) {
            return $dish->id()->equals($dishId);
        });

        /**
         * @var Dish $foundDish
         */
        if (!$foundDish = $filter->first()) {
            return;
        }

        $foundDish->cookingComplete();
        /**
         * @BusinessRule(title="Приготовить заказ, если все блюда в заказе готовы",
         *     description="Если в заказе все блюда пригтоовлены, то такой заказ можно считать полностью готовым.")
         */
        if (!$this->hasUncookedDishes()) {
            if ($this->cooked) {
                return;
            }

            $this->cooked = true;
            $this->record(new OrderCookedOnKitchen($this->id()->value()));
        }
    }

    protected function hasUncookedDishes(): bool
    {
        $filter = $this->dishes->filter(function (Dish $dish) {
            return !$dish->cooked();
        });

        return !$filter->isEmpty();
    }
}