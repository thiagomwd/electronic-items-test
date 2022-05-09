<?php

use fixtures\ElectronicItemFixture;
use PHPUnit\Framework\TestCase;

final class ElectronicItemsTest extends TestCase
{
    public function testValidMaxExtras() {
        $this->assertInstanceOf(
            ElectronicItems::class,
            new ElectronicItems(ElectronicItemFixture::okScenario1())
        );
    }

    public function testInValidMaxExtras() {
        $this->expectException(InvalidArgumentException::class);
        new ElectronicItems(ElectronicItemFixture::failScenario1());
    }

    public function testSumTotalCurrentItems() {
        $totalExpected = 1085;
        $electronicItems = new ElectronicItems(ElectronicItemFixture::okScenario1());
        $this->assertEquals($totalExpected, $electronicItems->getTotalPriceCurrentItems());
    }

    public function testSortItems() {
        $electronicItems = new ElectronicItems(ElectronicItemFixture::okScenario1());
        $items = $electronicItems->getSortedItems();
        $countItems = sizeof($items);

        $firstItemTypeExpected = ["type" => "microwave", "totalPrice" => 85];
        $lastItemTypeExpected = ["type" => "television", "totalPrice" => 420];

        $firstItem = [
            "type" => $items[0]->getType(),
            "totalPrice" => $items[0]->getTotalPrice()
        ];

        $lastItem = [
            "type" => $items[$countItems - 1]->getType(),
            "totalPrice" => $items[$countItems - 1]->getTotalPrice()
        ];

        $this->assertEqualsCanonicalizing($firstItemTypeExpected, $firstItem);
        $this->assertEqualsCanonicalizing($lastItemTypeExpected, $lastItem);
    }

    public function testFilterItemsType() {
        $typeExpected = ElectronicItem::ELECTRONIC_ITEM_MICROWAVE;
        $electronicItems = new ElectronicItems(ElectronicItemFixture::okScenario1());
        $isOnlyExpectedType = null;

        foreach($electronicItems->getItemsByType($typeExpected) as $item) {
            $isOnlyExpectedType = true;
            if($item->getType() != $typeExpected) {
                $isOnlyExpectedType = false;
                break;
            }
        }

        $this->assertTrue($isOnlyExpectedType);
    }
}