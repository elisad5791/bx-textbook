<h1>Получение большого списка лидов</h1>

<p>Часто встает задача импорта каких-либо сущностей с портала посредством rest. Для оптимизации процесса можно использовать пакетное выполнение запросов.</p>

<pre>
    <code>
        require_once(__DIR__ . '/crest.php');

        $call_count = 0;
        $data = [];

        $prevId = 0;
        while (true) {
            $batch = getBatch($prevId);
            $result = executeREST($batch, $call_count);
            if (!empty($result['result']['result'])) {
                foreach ($result['result']['result'] as $list) {
                    $last = end($list);
                    if ($last['ID'] > $prevId) {
                        $prevId = $last['ID'];
                        $data = array_merge($data, $list);
                    } else {
                        break 2;
                    }
                }
            } else {
                break;
            }
        }

        var_dump($data);

        /*--------------- функции --------------------------------*/

        function getBatch($prevId)
        {
            $batch = [];
            for ($i = 0; $i < 50; $i++) {
                $params = [
                    'order' => ['ID' => 'ASC'],
                    'filter' => ['>ID' => $prevId],
                    'select' => ['ID', 'TITLE'],
                    'start' => -1
                ];
                $batch['get_' . $i] = ['method' => 'crm.lead.list', 'params' => $params];
                $prevId = '$result[get_' . $i . '][49][ID]';
            }
            return $batch;
        }

        function executeREST($batch, &$call_count)
        {
            $call_count++;
            if ($call_count == 2) {
                sleep(1);
                $call_count = 0;
            }

            $result = CRest::callBatch($batch, 1);
            return $result;
        }
    </code>
</pre>