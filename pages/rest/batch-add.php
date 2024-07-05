<h1>Пакетное добавление лидов</h1>

<p>Часто встает задача добавления большого количества каких-либо сущностей посредством rest. Для оптимизации процесса можно использовать пакетное выполнение запросов.</p>

<pre>
    <code>
        require_once (__DIR__.'/crest.php');

        $call_count = 0;
        $total = 120;

        $current = 0;
        $calls = $total;
        $batch = [];
        $result = [];

        do {
            $current++;
            $fields = [
                'TITLE'=> "ИП Титов$current", 
                'NAME' => 'Глеб', 
                'SECOND_NAME' => 'Егорович', 
                'LAST_NAME' => "Титов$current", 
                'STATUS_ID' => 'NEW', 
                'OPENED' => 'Y', 
                'ASSIGNED_BY_ID' => 1, 
                'CURRENCY_ID' => 'USD', 
                'OPPORTUNITY' => 12500,
                'PHONE' => [[ 'VALUE' => '555888', 'VALUE_TYPE' => 'WORK']] ,
                'WEB' => [['VALUE' => 'www.mysite.com', 'VALUE_TYPE' => 'WORK']]
            ];
            $batch['add_' . $current] = ['method' => 'crm.lead.add', 'params' => compact('fields')];

            if (count($batch) == 50 || $current == $calls) {
                $batch_result = executeREST($batch, $call_count);
                $result = array_merge($result, $batch_result);
                $batch = [];
            }
        } while ($current < $calls);

        print_r($result);

        /*---------функция выполнения запроса ---------------------*/

        function executeREST($batch, &$call_count) {
            $call_count++;
            if ($call_count == 2) {
                sleep(1);
                $call_count = 0;
            }

            $result = CRest::callBatch($batch);
            return $result;
        }
    </code>
</pre>