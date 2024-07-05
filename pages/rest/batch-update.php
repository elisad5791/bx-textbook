<h1>Пакетное обновление лидов</h1>

<p>Часто встает задача обновления большого количества каких-либо сущностей посредством rest. Для оптимизации процесса можно использовать пакетное выполнение запросов.</p>

<pre>
    <code>
        require_once(__DIR__ . '/crest.php');

        $call_count = 0;

        /*-------------- получение всех id -------------------*/

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

        $ids = [];
        foreach ($data as $item) {
            $ids[] = $item['ID'];
        }

        /*--------------------  обновление -------------------------*/

        $current = 0;
        $calls = count($ids);
        $batch = [];
        $result = [];

        do {
            $current++;

            $params = [
                'id' => $ids[$current - 1],
                'fields' => ['STATUS_ID' => 'IN_PROCESS']
            ];
            $batch['update_' . $current] = ['method' => 'crm.lead.update', 'params' => $params];

            if (count($batch) == 50 || $current == $calls) {
                $batch_result = executeREST($batch, $call_count);
                $result = array_merge($result, $batch_result['result']['result']);
                $batch = [];
            }
        } while ($current < $calls);

        print_r($result);

        /*--------------- функции --------------------------------*/

        function getBatch($prevId)
        {
            $batch = [];
            for ($i = 0; $i < 50; $i++) {
                $params = [
                    'order' => ['ID' => 'ASC'],
                    'filter' => ['>ID' => $prevId],
                    'select' => ['ID'],
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