<?php
require_once "vendor/autoload.php";

try {
    echo "Question 1 answer: \n\n";
    $items = json_decode(file_get_contents('src/data/items.json'), true);
    $electronicItems = new ElectronicItems($items);
    $electronicItems->listItems();
    echo sprintf("total: $%s\n", number_format($electronicItems->getTotalPriceCurrentItems(), 2));

    echo "\n\nQuestion 2 answer: \n\n";

    $console = $electronicItems->getItemsByType(ElectronicItem::ELECTRONIC_ITEM_CONSOLE);
    echo sprintf("console and its controllers had cost: $%s\n", number_format($electronicItems->getTotalPriceItems($console), 2));
}catch (Exception $exception) {
    echo $exception->getMessage();
}