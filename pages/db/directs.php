<h1>Прямые запросы к БД</h1>

<pre>
  <code>
    global $DB;
    $results = $DB->Query("SELECT * FROM my_table");

    while($row = $results->Fetch()){
        var_dump($row);
    }
  </code>
</pre>