<h1>Сделки - основные операции</h1>

<h4>Получение списка сделок</h4>
<p>С использованием D7:</p>
<pre>
  <code>
    use Bitrix\Crm\DealTable;
    use Bitrix\Main\Entity\Query;

    $class = DealTable::getEntity();
    $query = new Query($class);
    $select = ['*'];
    $filter = ['CATEGORY_ID' => 27];
    $sort = ['ID' => 'ASC'];
    $query->setSelect($select)->setFilter($filter)->setOrder($sort);
    $deals = $query->exec()->fetchAll();
  </code>
</pre>
<p>Еще один вариант:</p>
<pre>
  <code>
    use Bitrix\Crm\DealTable;

    $arSelect = ['*'];
    $arSort = ['ID' => 'ASC'];
    $arFilter = ['CATEGORY_ID' => 27];

    $res = DealTable::getList(['select' => $arSelect, 'order' => $arSort, 'filter' => $arFilter]);
    $deals = $res->fetchAll();
  </code>
</pre>
<p>При использовании старого ядра принципы работы практически аналогичны выборке в инфоблоках.</p>
<p>По умолчанию при выборке проверяются права. Чтобы отменить проверку, в фильтре надо передать <mark>'CHECK_PERMISSIONS' => 'N'</mark</p>
<pre>
  <code class="language-php">
    use Bitrix\Main\Loader;

    Loader::includeModule('crm');

    $res = CCrmDeal::GetList([], ['>ID' => 3], false, false, ['ID', 'TITLE']);
    $deals = [];
    while ($deal = $res->Fetch()) {
      $deals[] = $deal;
    }
  </code>
</pre>
<p>Описание синтаксиса:</p>
<pre>
  <code>
    CCrmDeal::GetList($arOrder = [], $arFilter = [], $arGroupBy = false, $arNavStartParams = false, $arSelectFields = []);
  </code>
</pre>

<h4>Добавление сделки</h4>
<pre>
  <code>
  use Bitrix\Main\Loader;

  Loader::includeModule('crm');

  $deal = new CCrmDeal; 
  $fields = ['TITLE' => 'Test']; 
  $deal->add($fields);
  </code>
</pre>

<h4>Изменение сделки</h4>
<pre>
  <code>
  use Bitrix\Main\Loader;

  Loader::includeModule('crm');

  $id = 1;
  $deal = new CCrmDeal; 
  $fields = ['TITLE' => 'Test']; 
  $deal->update($id, $fields);
  </code>
</pre>

<h4>Удаление сделки</h4>
<pre>
  <code>
  use Bitrix\Main\Loader;

  Loader::includeModule('crm');

  $id = 1;
  $deal = new CCrmDeal; 
  $deal->delete($id);
  </code>
</pre>

<h4>Получение списка пользовательских полей</h4>
<pre>
  <code>
    $arFields = $USER_FIELD_MANAGER->GetUserFields('CRM_DEAL');
    $userFields = array_keys($arFields);
  </code>
</pre>

<h4>Получение товаров сделки</h4>
<pre>
  <code>
    use CCrmProductRow;

    $arFilter = [
        "OWNER_TYPE" => 'D',
        "OWNER_ID" => $id,
        "CHECK_PERMISSIONS"=>'N',
    ];
    $rs = CCrmProductRow::GetList([], $arFilter);
    $products = [];
    while ($product = $rs->Fetch())  {
        $products[] = $product;
    }
  </code>
</pre>