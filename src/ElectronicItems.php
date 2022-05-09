<?php

class ElectronicItems
{
    /**
     * @var ElectronicItem[]
     */
    private array $items;

    /**
     * @throws Exception
     */
    public function __construct(array $items)
    {
        $this->setElectronicItems($items);
    }

    /**
     * Set items required to purchase
     * @throws Exception
     */
    private function setElectronicItems(array $items): void {
        if(!empty($items)) {
            foreach($items as $item) {
                $electronicItem = ElectronicItem::newInstance($item);
                if(!$this->isValidItemExtras($electronicItem)) {
                    throw new InvalidArgumentException(sprintf("The item '%s' exceeded the limit of extras",
                        $electronicItem->getType()));
                }
                $this->items[] = $electronicItem;
            }
        }
    }

    /**
     * check if an item has a count of extras items valid
     * @throws Exception
     */
    public function isValidItemExtras(ElectronicItem $electronicItem): bool
    {
        if(is_null($electronicItem->maxExtras())) {
            return true;
        }

        if(sizeof($electronicItem->getExtras()) > $electronicItem->maxExtras()) {
            return false;
        }

        return true;
    }

    /**
     * Returns the items depending on the sorting type requested
     *
     * @param string $type
     * @return array
     */
    public function getSortedItems(string $type = "asc"): array
    {
        $sorted = array();
        $sortMethod = $type == "asc"? "ksort": "krsort";

        foreach ($this->items as $item)
        {
            $sorted[($item->getTotalPrice() * 100)] = $item;
        }

        $sortMethod($sorted, SORT_NUMERIC);
        return array_values($sorted);
    }
    /**
     *
     * @param string $type
     * @return array
     */
    public function getItemsByType(string $type): array
    {
        $items = [];
        if (in_array($type, ElectronicItem::$types))
        {
            $callback = function(ElectronicItem $item) use ($type)
            {
                return $item->getType() == $type;
            };
            $items = array_filter($this->items, $callback);
        }
        return $items;
    }

    /**
     * @param ElectronicItem[] $items
     * @return void
     */
    public function listItems() {
        foreach ($this->items as $item) {
            echo sprintf("%s: $%s \n", $item->getType(), number_format($item->getPrice(), 2));
            if(!empty($item->getExtras())) {
                $this->listExtrasItems($item->getExtras());
            }
            echo "\n";
        }
    }

    /**
     * @param ElectronicItem[] $items
     * @return void
     */
    public function listExtrasItems(array $items) {
        echo ("----------------- Extras -----------------\n");
        foreach ($items as $item) {
            echo sprintf(" - %s: $%s \n", $item->getType(), number_format($item->getPrice(), 2));
            if(!empty($item->getExtras())) {
                $this->listItems($item->getExtras());
            }
        }
    }

    public function getTotalPriceCurrentItems(): float
    {
        return $this->getTotalPriceItems($this->items);
    }

    /**
     * @param ElectronicItem[] $items
     * @return float
     */
    public function getTotalPriceItems(array $items): float {
        return array_reduce( $items, function ($sumPrices, ElectronicItem $item) {
            $sumPrices += $item->getTotalPrice();
            return $sumPrices;
        }, 0);
    }
}