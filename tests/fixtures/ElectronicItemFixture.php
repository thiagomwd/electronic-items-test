<?php

namespace fixtures;

use ElectronicItem;

class ElectronicItemFixture
{

    public static function createElectronicItem($type, $price, $wired = true, $extras = []): array
    {
        $item = [
            "type" => $type,
            "price" => $price,
            "wired" => true
        ];
        if(!empty($extras)) {
            $item["extras"] = $extras;
        }

        return $item;
    }

    public static function createController($price, $wired = true, $extras = []): array
    {
        return self::createElectronicItem(ElectronicItem::ELECTRONIC_ITEM_CONTROLLER, $price, $wired, $extras);
    }

    public static function createTelevision($price, $wired = true, $extras = []): array
    {
        return self::createElectronicItem(ElectronicItem::ELECTRONIC_ITEM_TELEVISION, $price, $wired, $extras);
    }

    public static function createMicrowave($price, $wired = true, $extras = []): array
    {
        return self::createElectronicItem(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE, $price, $wired, $extras);
    }

    public static function createConsole($price, $wired = true, $extras = []): array
    {
        return self::createElectronicItem(ElectronicItem::ELECTRONIC_ITEM_CONSOLE, $price, $wired, $extras);
    }


    /**
     * 1 console, 2 televisions with different prices and 1 microwave
        The console and televisions have extras; those extras are controllers. The console has 2 remote
        controllers and 2 wired controllers. The TV #1 has 2 remote controllers and the TV #2 has 1
        remote controller.
     * @return array[]
     */
    public static function okScenario1(): array
    {
        return [
          self::createConsole(350, true, [
              self::createController(10,true),
              self::createController(10,true),
          ]),
          self::createTelevision(400, true, [
              self::createController(10),
              self::createController(10),
          ]),
          self::createTelevision(200, true, [
              self::createController(10),
          ]),
          self::createMicrowave(85),
        ];
    }

    public static function failScenario1(): array
    {
        return [
            self::createConsole(350, true, [
                self::createController(10,true),
                self::createController(10,true),
                self::createController(10,true),
                self::createController(10,true),
                self::createController(10,true),
            ])
        ];
    }
}