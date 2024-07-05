<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Query;
use Bitrix\Iblock\ElementTable;

Loader::includeModule('iblock');

$class = ElementTable::getEntity();
$query = new Query($class);

$query->registerRuntimeField(
  'ELEMENT_COUNT',
  [
    'data_type' => 'integer',
    'expression' => ['COUNT(%s)', 'NAME']
  ]
);
$query->registerRuntimeField(
  'ELEMENT_LIST',
  [
    'data_type' => 'string',
    'expression' => ['GROUP_CONCAT(%s)', 'NAME']
  ]
);

$query->setSelect(['IBLOCK_SECTION.NAME', 'ELEMENT_COUNT', 'ELEMENT_LIST']);
$query->setFilter(['=ACTIVE' => 'Y', '=IBLOCK_SECTION.ACTIVE' => 'Y']);
$query->addFilter('IBLOCK.ID', 5);

echo $query->getQuery();

$result = $query->exec();
while ($row = $result->fetch()) {
  var_dump($row);
}