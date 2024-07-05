<h1>Работа с БД на низком уровне</h1>

<h4>Запрос к БД</h4>
<pre>
  <code>
    use Bitrix\Main\Application;

    $connection = Application::getConnection();

    $login = 'admin';
    $sqlHelper = $connection->getSqlHelper();
    $data = $sqlHelper->forSql($login, 50);

    $query = "SELECT NAME, LAST_NAME, EMAIL FROM b_user WHERE LOGIN = '". $data ."'";
    $result = $connection->query($query);

    if ($user = $result->fetch()) {
      var_dump($user);
    }
  </code>
</pre>
<p>Результат выполнения запроса:</p>
<pre>
  <code>
      [
        'NAME' => 'Сергей',
        'LAST_NAME' => 'Иванов',
        'EMAIL' => 'ivanov.s@host14.ru'
      ]
  </code>
</pre>

<h4>Настройки подключения к БД</h4>
<p>Настройки подключения к базе данных находятся в файле <mark>bitrix/.settings.php</mark></p>
<pre>
  <code>
    ...
      'connections' => [
        'value' => [
          'default' => [
            'className' => '\\Bitrix\\Main\\DB\\MysqliConnection',
            'host' => 'localhost',
            'database' => 'bitrix3', 
            'login' => 'bitrix3',
            'password' => '.....',
            'options' => 2.0,
          ]
        ]
      ]
    ...
  </code>
</pre>

<h4>Скалярный запрос</h4>
<pre>
  <code>
    $query = "SELECT COUNT(ID) FROM b_user";
    $count = $connection->queryScalar($query);
  </code>
</pre>
<p>Возвращает не массив, а конкретное значение</p>

<h4>Запрос без получения результата</h4>
<pre>
  <code>
    $connection->queryExecute("INSERT INTO some_table(NAME, SORT) VALUES ('Название', 100)");
  </code>
</pre>

<h4>Удалить таблицу</h4>
<pre>
  <code>
    $connection->dropTable($tableName);
  </code>
</pre>

<h4>Очистить таблицу</h4>
<pre>
  <code>
    $connection->truncateTable($tableName);
  </code>
</pre>

<h4>Проверить существование таблицы</h4>
<pre>
  <code>
    $connection->isTableExists($tableName);
  </code>
</pre>

<h4>Переименовать таблицу</h4>
<pre>
  <code>
    $connection->renameTable($oldName, $newName);
  </code>
</pre>

<h4>Получить поля таблицы</h4>
<pre>
  <code>
    $connection->getTableFields($tableName);
  </code>
</pre>

<h4>Удалить колонку в таблице</h4>
<pre>
  <code>
    $connection->dropColumn($tableName, $columnName);
  </code>
</pre>

<h4>Создать первичный ключ</h4>
<pre>
  <code>
    $connection->createPrimaryIndex($tableName, $columnNames);
  </code>
</pre>

<h4>Создать индекс</h4>
<pre>
  <code>
    $connection->createIndex($tableName, $indexName, $columnNames);
  </code>
</pre>