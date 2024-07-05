<h1>Лиды - основные операции</h1>

<h4>Добавление лида</h4>
<pre>
  <code>
  use Bitrix\Main\Loader;

  Loader::includeModule('crm');

  $lead = new CCrmLead; 
  $fields = ['TITLE' => 'Test']; 
  $lead->add($fields);
  </code>
</pre>

<h4>Изменение лида</h4>
<pre>
  <code>
  use Bitrix\Main\Loader;

  Loader::includeModule('crm');

  $id = 1;
  $lead = new CCrmLead; 
  $fields = ['TITLE' => 'Test']; 
  $lead->update($id, $fields);
  </code>
</pre>

<h4>Удаление лида</h4>
<pre>
  <code>
  use Bitrix\Main\Loader;

  Loader::includeModule('crm');

  $id = 1;
  $lead = new CCrmLead; 
  $lead->delete($id);
  </code>
</pre>

<h4>Получение списка лидов</h4>
<p>Принципы работы практически аналогичны выборке в инфоблоках.</p>
<p>По умолчанию при выборке проверяются права. Чтобы отменить проверку, в фильтре надо передать <mark>'CHECK_PERMISSIONS' => 'N'</mark</p>
<pre>
  <code class="language-php">
    use Bitrix\Main\Loader;

    Loader::includeModule('crm');

    CCrmLead::GetList([], ['>ID' => 3], false, false, ['ID', 'TITLE']);
  </code>
</pre>
<p>Описание синтаксиса:</p>
<pre>
  <code>
    CCrmLead::GetList($arOrder = [], $arFilter = [], $arGroupBy = false, $arNavStartParams = false, $arSelectFields = []);
  </code>
</pre>