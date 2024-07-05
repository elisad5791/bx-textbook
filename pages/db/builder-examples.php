<h1>Построитель запросов - примеры</h1>

<h4>1. Простой запрос на выборку</h4>
<p>Выбираем элементы инфоблока с идентификатором 5:</p>
<pre>
  <code>
    use Bitrix\Main\Loader;
    use Bitrix\Main\Entity\Query;
    use Bitrix\Iblock\ElementTable;

    Loader::includeModule('iblock');

    $class = ElementTable::getEntity();
    $query = new Query($class);

    $query->setSelect(['ID', 'CODE', 'NAME'])
          ->setFilter(['IBLOCK_ID' => 5])
          ->setOrder(['ID' => 'ASC'])
          ->setLimit(3);

    echo $query->getQuery();

    $result = $query->exec();
    while ($row = $result->fetch()) {
        var_dump($row);
    }
  </code>
</pre>
<p>Метод <mark>getQuery()</mark> возвращает сформированный SQL-запрос:</p>
<pre>
  <code>
    SELECT
      `iblock_element`.`ID` AS `ID`,
      `iblock_element`.`CODE` AS `CODE`,
      `iblock_element`.`NAME` AS `NAME`
    FROM `b_iblock_element` `iblock_element`
    WHERE `iblock_element`.`IBLOCK_ID` = 5
    ORDER BY `ID` ASC
    LIMIT 0, 3
  </code>
</pre>
<p>Полученный результат:</p>
<pre>
  <code>
    [
      [ID] => 347
      [CODE] => angliyskiy-buldog
      [NAME] => Английский бульдог
    ]
    [
      [ID] => 348
      [CODE] => dalmatin
      [NAME] => Далматин
    ]
    [
      [ID] => 349
      [CODE] => afganskaya-borzaya
      [NAME] => Афганская борзая
    ]
  </code>
</pre>

<h4>2. Запрос с использованием соединения</h4>
<p>Через сущность <mark>ElementTable</mark>, можно выбирать или ставить условия на поля связанной сущности, в данном примере это <mark>IBLOCK</mark>. Связанная таблица по умолчанию присоединяется с помощью <mark>LEFT JOIN</mark>. Вспомним <mark>reference</mark> поле <mark>IBLOCK</mark> в описании <mark>ElementTable</mark>:</p>
<pre>
  <code>
    'IBLOCK' => [
      'data_type' => 'Bitrix\Iblock\Iblock',
      'reference' => array('=this.IBLOCK_ID' => 'ref.ID'),
    ]
  </code>
</pre>
<p>Выберем данные инфоблока с идентификатором 5 вместе с элементами инфоблока:</p>
<pre>
  <code>
    use Bitrix\Main\Loader;
    use Bitrix\Iblock\ElementTable;
    use Bitrix\Main\Entity\Query;

    Loader::includeModule('iblock');

    $class =  ElementTable::getEntity();
    $query = new Query($class);

    $query->setSelect(['ID', 'CODE', 'NAME', 'IBLOCK.ID', 'IBLOCK.CODE', 'IBLOCK.NAME'])
          ->setFilter(['IBLOCK.ID' => 5])
          ->setOrder(['ID' => 'ASC'])
          ->setLimit(3);

    echo $query->getQuery();

    $result = $query->exec();
    while ($row = $result->fetch()) {
        var_dump($row);
    }
  </code>
</pre>
<p>Полученный SQL-запрос:</p>
<pre>
  <code>
  SELECT
    `iblock_element`.`ID` AS `ID`,
    `iblock_element`.`CODE` AS `CODE`,
    `iblock_element`.`NAME` AS `NAME`,
    `iblock_element_iblock`.`ID` AS `IBLOCK_ELEMENT_IBLOCK_ID`,
    `iblock_element_iblock`.`CODE` AS `IBLOCK_ELEMENT_IBLOCK_CODE`,
    `iblock_element_iblock`.`NAME` AS `IBLOCK_ELEMENT_IBLOCK_NAME`
  FROM `b_iblock_element` `iblock_element` 
  LEFT JOIN `b_iblock` `iblock_element_iblock` ON `iblock_element`.`IBLOCK_ID` = `iblock_element_iblock`.`ID`
  WHERE `iblock_element_iblock`.`ID` = 5
  ORDER BY `ID` ASC
  LIMIT 0, 3
  </code>
</pre>
<p>Результат:</p>
<pre>
  <code>
    [
      [ID] => 347
      [CODE] => angliyskiy-buldog
      [NAME] => Английский бульдог
      [IBLOCK_ELEMENT_IBLOCK_ID] => 5
      [IBLOCK_ELEMENT_IBLOCK_CODE] => articles
      [IBLOCK_ELEMENT_IBLOCK_NAME] => Статьи о домашних животных
    ]
    [
      [ID] => 348
      [CODE] => dalmatin
      [NAME] => Далматин
      [IBLOCK_ELEMENT_IBLOCK_ID] => 5
      [IBLOCK_ELEMENT_IBLOCK_CODE] => articles
      [IBLOCK_ELEMENT_IBLOCK_NAME] => Статьи о домашних животных
    ]
    [
      [ID] => 349
      [CODE] => afganskaya-borzaya
      [NAME] => Афганская борзая
      [IBLOCK_ELEMENT_IBLOCK_ID] => 5
      [IBLOCK_ELEMENT_IBLOCK_CODE] => articles
      [IBLOCK_ELEMENT_IBLOCK_NAME] => Статьи о домашних животных
    ]
  </code>
</pre>

<h4>3. Запрос со ссылкой на другую сущность</h4>
<p>В запросе можно использовать <mark>Runtime</mark> поля, содержащие ссылку на другую сущность. Т.е. в методе <mark>getMap()</mark> можно не описывать связь, а сформировать ее прямо в запросе. Например, создадим объект <mark>Query</mark> для сущности <mark>IblockTable</mark>, свяжем ее с <mark>ElementTable</mark> и выберем элемент с ID=349:</p>
<pre>
  <code>
    use Bitrix\Main\Loader;
    use Bitrix\Main\Entity\Query;
    use Bitrix\Iblock\IblockTable;

    Loader::includeModule('iblock');

    $class = IblockTable::getEntity();
    $query = new Query($class);

    $query->registerRuntimeField( 
        'element',
        [
            'data_type' => 'Bitrix\Iblock\ElementTable',
            'reference' => ['=this.ID' => 'ref.IBLOCK_ID'],
        ]
    );
    $query->setSelect(['element.NAME', 'element.CODE', 'element.PREVIEW_TEXT', 'element.SHOW_COUNTER',  'NAME']);
    $query->setFilter(['element.ID' => 349]);

    echo $query->getQuery();

    $result = $query->exec();
    while ($row = $result->fetch()) {
        var_dump($row);
    }
  </code>
</pre>
<p>Получившийся запрос:</p>
<pre>
  <code>
    SELECT
      `iblock_iblock_element`.`NAME` AS `IBLOCK_IBLOCK_element_NAME`,
      `iblock_iblock_element`.`CODE` AS `IBLOCK_IBLOCK_element_CODE`,
      `iblock_iblock_element`.`PREVIEW_TEXT` AS `IBLOCK_IBLOCK_element_PREVIEW_TEXT`,
      `iblock_iblock_element`.`SHOW_COUNTER` AS `IBLOCK_IBLOCK_element_SHOW_COUNTER`,
      `iblock_iblock`.`NAME` AS `NAME`
    FROM `b_iblock` `iblock_iblock` 
    LEFT JOIN `b_iblock_element` `iblock_iblock_element` ON `iblock_iblock`.`ID` = `iblock_iblock_element`.`IBLOCK_ID`
    WHERE `iblock_iblock_element`.`ID` = 349
  </code>
</pre>
<p>Результат:</p>
<pre>
  <code>
    [
      [IBLOCK_IBLOCK_element_NAME] => Афганская борзая
      [IBLOCK_IBLOCK_element_CODE] => afganskaya-borzaya
      [IBLOCK_IBLOCK_element_PREVIEW_TEXT] => Изящная красавица с длинной развевающейся на бегу шелковистой шерстью...
      [IBLOCK_IBLOCK_element_SHOW_COUNTER] => 10
      [NAME] => Статьи о домашних животных
    ]
  </code>
</pre>

<h4>4. Запрос с использованием сложного соединения</h4>
<p>В определении <mark>runtime-reference</mark> поля можно указывать тип соединения <mark>LEFT</mark>, <mark>RIGHT</mark>, <mark>INNER</mark>. В фильтре можно использовать сложную логику.</p>
<pre>
  <code>
    use Bitrix\Main\Loader;
    use Bitrix\Main\Entity\Query;
    use Bitrix\Iblock\IblockTable;

    Loader::includeModule('iblock');

    $class = IblockTable::getEntity();
    $query = new Query($class);

    $query->registerRuntimeField(
        'element',
        [
            'data_type' => 'Bitrix\Iblock\ElementTable',
            'reference' => ['=this.ID' => 'ref.IBLOCK_ID'],
            'join_type' => 'INNER'
        ]
    );

    $query->registerRuntimeField(
        'type',
        [
            'data_type' => 'Bitrix\Iblock\TypeTable',
            'reference' => ['=this.IBLOCK_TYPE_ID' => 'ref.ID'],
            'join_type' => 'INNER'
        ]
    );

    $query->setSelect(['NAME', 'CODE', 'element.NAME', 'element.CODE', 'type.ID']);
    $query->setFilter(['LOGIC' => 'OR', ['element.ID' => 348], ['element.ID' => 349]]);

    echo $query->getQuery();

    $result = $query->exec();
    while ($row = $result->fetch()) {
        var_dump($row);
    }
  </code>
</pre>
<p>Сформированный запрос:</p>
<pre>
  <code>
    SELECT
      `iblock_iblock`.`NAME` AS `NAME`,
      `iblock_iblock`.`CODE` AS `CODE`,
      `iblock_iblock_element`.`NAME` AS `IBLOCK_IBLOCK_element_NAME`,
      `iblock_iblock_element`.`CODE` AS `IBLOCK_IBLOCK_element_CODE`,
      `iblock_iblock_type`.`ID` AS `IBLOCK_IBLOCK_type_ID`
    FROM `b_iblock` `iblock_iblock`
    INNER JOIN `b_iblock_element` `iblock_iblock_element` ON `iblock_iblock`.`ID` = `iblock_iblock_element`.`IBLOCK_ID`
    INNER JOIN `b_iblock_type` `iblock_iblock_type` ON `iblock_iblock`.`IBLOCK_TYPE_ID` = `iblock_iblock_type`.`ID`
    WHERE (`iblock_iblock_element`.`ID` = 348) OR (`iblock_iblock_element`.`ID` = 349)
  </code>
</pre>
<p>Результат:</p>
<pre>
  <code>
    [
      [NAME] => Статьи о домашних животных
      [CODE] => articles
      [IBLOCK_IBLOCK_element_NAME] => Далматин
      [IBLOCK_IBLOCK_element_CODE] => dalmatin
      [IBLOCK_IBLOCK_type_ID] => content
    ]
    [
      [NAME] => Статьи о домашних животных
      [CODE] => articles
      [IBLOCK_IBLOCK_element_NAME] => Афганская борзая
      [IBLOCK_IBLOCK_element_CODE] => afganskaya-borzaya
      [IBLOCK_IBLOCK_type_ID] => content
    ]
  </code>
</pre>

<h4>5. Запрос на получение пользовательских свойств</h4>
<p>Получим пользовательские свойства элементов инфоблока с идентификатором 5:</p>
<pre>
  <code>
    use Bitrix\Main\Loader;
    use Bitrix\Main\Entity\Query;
    use Bitrix\Iblock\PropertyTable;

    Loader::includeModule('iblock');

    $class = PropertyTable::getEntity();
    $query = new Query($class);

    $query->setSelect(['ID', 'NAME', 'CODE', 'PROPERTY_TYPE']);
    $query->setFilter(['IBLOCK_ID' => 5]);

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
      `iblock_property`.`ID` AS `ID`,
      `iblock_property`.`NAME` AS `NAME`,
      `iblock_property`.`CODE` AS `CODE`,
      `iblock_property`.`PROPERTY_TYPE` AS `PROPERTY_TYPE`
    FROM `b_iblock_property` `iblock_property`
    WHERE `iblock_property`.`IBLOCK_ID` = 5
  </code>
</pre>
<p>Результат:</p>
<pre>
  <code>
    [
      [ID] => 47
      [NAME] => Автор
      [CODE] => AUTHOR
      [PROPERTY_TYPE] => S
    ]
    [
      [ID] => 48
      [NAME] => Оценка
      [CODE] => RATING
      [PROPERTY_TYPE] => L
    ]
    [
      [ID] => 49
      [NAME] => Галерея
      [CODE] => GALLERY
      [PROPERTY_TYPE] => F
    ]
    [
      [ID] => 51
      [NAME] => Примечание
      [CODE] => NOTE
      [PROPERTY_TYPE] => S
    ]
  </code>
</pre>