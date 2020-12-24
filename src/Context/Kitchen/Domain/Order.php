<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Domain;

use App\Context\Kitchen\Domain\Event\OrderCookedOnKitchen;
use App\Context\Kitchen\Domain\Event\OrderCreatedOnKitchen;
use App\Context\Shared\Domain\AggregateRoot;
use Doctrine\Common\Collections\Collection;

class Order extends AggregateRoot
{
    /**
     * @var Collection
     */
    private Collection $dishes;
    private bool $cooked;

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

        if (!$this->hasUncookedDishes()) {
            $this->orderCookingComplete();
        }
    }

    protected function orderCookingComplete(): void
    {
        if ($this->cooked) {
            return;
        }

        $this->cooked = true;
        $this->record(new OrderCookedOnKitchen($this->id()->value()));
    }

    protected function hasUncookedDishes(): bool
    {
        $filter = $this->dishes->filter(function (Dish $dish) {
            return !$dish->cooked();
        });

        return !$filter->isEmpty();
    }
}