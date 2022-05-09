<?php

class ElectronicItem
{
    private float $price;
    private string $type;
    private bool $wired;
    /**
     * @var ElectronicItem[]
     */
    private array $extras;

    const ELECTRONIC_ITEM_TELEVISION = 'television';
    const ELECTRONIC_ITEM_CONSOLE = 'console';
    const ELECTRONIC_ITEM_MICROWAVE = 'microwave';
    const ELECTRONIC_ITEM_CONTROLLER = 'controller';

    public static array $types = [
        self::ELECTRONIC_ITEM_CONSOLE,
        self::ELECTRONIC_ITEM_MICROWAVE,
        self::ELECTRONIC_ITEM_TELEVISION,
        self::ELECTRONIC_ITEM_CONTROLLER
    ];

    // null = unlimited
    private array $typesMaxExtras = [
        self::ELECTRONIC_ITEM_CONSOLE => 4,
        self::ELECTRONIC_ITEM_MICROWAVE => 0,
        self::ELECTRONIC_ITEM_TELEVISION => null,
        self::ELECTRONIC_ITEM_CONTROLLER => 0
    ];

    /**
     * Build a new instance of ElectronicItem
     * @param $data
     * @return ElectronicItem
     */
    public static function newInstance($data): ElectronicItem
    {
        $instance = new ElectronicItem();

        if(!empty($data)) {
            $instance->setPrice($data["price"]);
            $instance->setType($data["type"]);
            $instance->setWired($data["wired"]);
            $instance->setExtras([]);
            if(!empty($data["extras"])) {
                $instance->setExtras(array_map(function(array $data) {
                    return self::newInstance($data);
                }, $data["extras"]));
            }
        }

        return $instance;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setWired($wired)
    {
        $this->wired = $wired;
    }

    public function isWired(): bool
    {
        return $this->wired;
    }

    /**
     * @return ElectronicItem[]
     */
    public function getExtras(): array
    {
        return $this->extras;
    }

    /**
     * @param string[] $extras
     */
    public function setExtras(array $extras): void
    {
        $this->extras = $extras;
    }

    /**
     * get max of extras by type
     * @throws Exception
     */
    public function maxExtras() {
        if (!in_array($this->getType(), ElectronicItem::$types)) {
            throw new Exception("Type not found");
        }

        return $this->typesMaxExtras[$this->getType()];
    }

    /**
     * Get a total price of an item with its extras
     * @return float
     */
    public function getTotalPrice(): float
    {
        $total = $this->getPrice();
        if(!empty($this->getExtras())) {
            foreach($this->getExtras() as $extra) {
                $total += $extra->getPrice();
            }
        }
        return $total;
    }

}