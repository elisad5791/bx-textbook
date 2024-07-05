<h1>Построитель запросов - агрегатные функции</h1>

<h4>Агрегация названий</h4>
<p>В запросах можно использовать агрегатные функции MySQL. Это делается с помощью <mark>runtime</mark>-полей. Посмотрим,
  сколько активных элементов в инфоблоке:</p>
<pre>
  <code>
    use Bitrix\Main\Loader;
    use Bitrix\Main\Entity\Query;
    use Bitrix\Iblock\ElementTable;

    Loader::includeModule('iblock');

    $class = ElementTable::getEntity();
    $query = new Query($class);

    $query->registerRuntimeField(
      'ACTIVE_ELEMENTS',
      [
        'data_type' => 'string',
        'expression' => ['GROUP_CONCAT(%s)', 'NAME']
      ]
    );
    $query->setSelect(['IBLOCK.NAME', 'ACTIVE_ELEMENTS']);
    $query->setFilter(['IBLOCK.ID' => 5, '=ACTIVE' => 'Y']);

    echo $query->getQuery();

    $result = $query->exec();
    while ($row = $result->fetch()) {
        var_dump($row);
    }
  </code>
</pre>
<p>Запрос:</p>
<pre>
  <code language="sql">
    SELECT
      `iblock_element_iblock`.`NAME` AS `IBLOCK_ELEMENT_IBLOCK_NAME`,
      GROUP_CONCAT(`iblock_element`.`NAME`) AS `ACTIVE_ELEMENTS`
    FROM `b_iblock_element` `iblock_element` 
    LEFT JOIN `b_iblock` `iblock_element_iblock` ON `iblock_element`.`IBLOCK_ID` = `iblock_element_iblock`.`ID`
    WHERE `iblock_element_iblock`.`ID` = 5 AND `iblock_element`.`ACTIVE` = 'Y'
    GROUP BY `iblock_element_iblock`.`NAME`
  </code>
</pre>
<p>Результат:</p>
<pre>
  <code>
    [
      [IBLOCK_ELEMENT_IBLOCK_NAME] => Статьи о домашних животных
      [ACTIVE_ELEMENTS] => Английский бульдог,Далматин,Афганская борзая,Абиссинская кошка,Сиамская кошка,Американский бобтейл,Британская короткошерстная,Лабрадор,Лайка
    ]
  </code>
</pre>

<h4>Подсчет количества</h4>
<p>Выберем разделы инфоблока с идентифкатором 5 и подсчитаем количество элементов в каждом, учитывая только активные разделы и элементы:</p>
<pre>
  <code>
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
  </code>
</pre>
<p>Запрос:</p>
<pre>
  <code>
    SELECT
      `iblock_element_iblock_section`.`NAME` AS `IBLOCK_ELEMENT_IBLOCK_SECTION_NAME`,
      COUNT(`iblock_element`.`NAME`) AS `ELEMENT_COUNT`,
      GROUP_CONCAT(`iblock_element`.`NAME`) AS `ELEMENT_LIST`
    FROM `b_iblock_element` `iblock_element`
    LEFT JOIN `b_iblock_section` `iblock_element_iblock_section` ON `iblock_element`.`IBLOCK_SECTION_ID` = `iblock_element_iblock_section`.`ID`
    LEFT JOIN `b_iblock` `iblock_element_iblock` ON `iblock_element`.`IBLOCK_ID` = `iblock_element_iblock`.`ID`
    WHERE
    `iblock_element`.`ACTIVE` = 'Y' AND
    `iblock_element_iblock_section`.`ACTIVE` = 'Y' AND
    `iblock_element_iblock`.`ID` = 5
    GROUP BY `iblock_element_iblock_section`.`NAME`
  </code>
</pre>
<p>Результат:</p>
<pre>
  <code>
    [
      [IBLOCK_ELEMENT_IBLOCK_SECTION_NAME] => Породы кошек
      [ELEMENT_COUNT] => 4
      [ELEMENT_LIST] => Абиссинская кошка,Сиамская кошка,Американский бобтейл,Британская короткошерстная
    ]
    [
      [IBLOCK_ELEMENT_IBLOCK_SECTION_NAME] => Породы собак
      [ELEMENT_COUNT] => 3
      [ELEMENT_LIST] => Английский бульдог,Далматин,Афганская борзая
    ]
    [
      [IBLOCK_ELEMENT_IBLOCK_SECTION_NAME] => Служебные породы
      [ELEMENT_COUNT] => 2
      [ELEMENT_LIST] => Лабрадор,Лайка
    ]
  </code>
</pre>