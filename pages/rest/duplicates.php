<h1>Поиск дубликатов по телефону, email</h1>

<p>Поиск дубликатов с помощью метода <mark>crm.duplicate.findbycomm</mark> можно выполнять по номеру телефона (тип PHONE) или email (тип EMAIL). В скрипте ниже составляется пакет запросов для отправки методом <mark>batch</mark>. Первый запрос получает идентификаторы дубликатов, последующие - все необходимые данные найденных дубликатов, а также объектов, которые с ними связаны (сделок, у которых в <mark>CONTACT_ID</mark> прикреплен найденный контакт; лидов, у которых в <mark>COMPANY_ID</mark> прикреплена найденная компания и т.п.). Необходимо отметить следующие проблемы этого скрипта. Во-первых, если метод <mark>crm.duplicate.findbycomm</mark> не найдет сущностей какого-типа (например, нет лидов с заданным телефоном), то последующие запросы могут работать некорректно. Эту ситуацию необходимо как-то обрабатывать. Во-вторых, при поиске связанных сущностей по полю <mark>CONTACT_ID</mark>, будут найдены только те, у которых заданный контакт прикреплен как основной. Если контакт прикреплен вторым, третьим и т.д., сущность в результат выполнения запроса не попадет. То же относится и к полю <mark>COMPANY_ID</mark>, если компаний может быть прикреплено несколько.</p>

<pre>
    <code>
        require_once(__DIR__ . '/crest.php');

        $select = [
            'LEAD' => ['ID', 'TITLE', 'DATE_CREATE', 'DATE_MODIFY', 'STATUS_ID', 'ASSIGNED_BY_ID', 'PHONE', 'CONTACT_ID', 'COMPANY_ID'],
            'COMPANY' => ['ID', 'TITLE', 'DATE_CREATE', 'DATE_MODIFY', 'ASSIGNED_BY_ID', 'PHONE', 'LEAD_ID'],
            'CONTACT' => ['ID', 'NAME', 'LAST_NAME', 'DATE_CREATE', 'DATE_MODIFY', 'ASSIGNED_BY_ID', 'PHONE', 'LEAD_ID', 'COMPANY_ID'],
            'DEAL' => ['ID', 'TITLE', 'DATE_CREATE', 'DATE_MODIFY', 'STAGE_ID', 'ASSIGNED_BY_ID', 'LEAD_ID', 'CONTACT_ID', 'COMPANY_ID']
        ];

        $value = '89191234567';
        $batch = [];

        $params = [
            'type' => 'PHONE',
            'values' => [$value]
        ];
        $batch['duplicates'] = ['method' => 'crm.duplicate.findbycomm', 'params' => $params];

        $params = ['order' => ['ID' => 'DESC']];

        // лиды и их связи
        $params['select'] = $select['LEAD'];
        $params['filter'] = ['ID' => '$result[duplicates][LEAD]'];
        $batch['lead_phone_data'] = ['method' => 'crm.lead.list', 'params' => $params];

        $params['filter'] = ['LEAD_ID' => '$result[duplicates][LEAD]'];
        $params['select'] = $select['DEAL'];
        $batch['deal_lead_data'] = ['method' => 'crm.deal.list', 'params' => $params];
        $params['select'] = $select['COMPANY'];
        $batch['company_lead_data'] = ['method' => 'crm.company.list', 'params' => $params];
        $params['select'] = $select['CONTACT'];
        $batch['contact_lead_data'] = ['method' => 'crm.contact.list', 'params' => $params];

        // компании и их связи
        $params['select'] = $select['COMPANY'];
        $params['filter'] = ['ID' => '$result[duplicates][COMPANY]'];
        $batch['company_phone_data'] = ['method' => 'crm.company.list', 'params' => $params];

        $params['filter'] = ['COMPANY_ID' => '$result[duplicates][COMPANY]'];
        $params['select'] = $select['LEAD'];
        $batch['lead_company_data'] = ['method' => 'crm.lead.list', 'params' => $params];
        $params['select'] = $select['DEAL'];
        $batch['deal_company_data'] = ['method' => 'crm.deal.list', 'params' => $params];
        $params['select'] = $select['CONTACT'];
        $batch['contact_company_data'] = ['method' => 'crm.contact.list', 'params' => $params];

        // контакты и их связи
        $params['select'] = $select['CONTACT'];
        $params['filter'] = ['ID' => '$result[duplicates][CONTACT]'];
        $batch['contact_phone_data'] = ['method' => 'crm.contact.list', 'params' => $params];

        $params['filter'] = ['CONTACT_ID' => '$result[duplicates][CONTACT]'];
        $params['select'] = $select['LEAD'];
        $batch['lead_contact_data'] = ['method' => 'crm.lead.list', 'params' => $params];
        $params['select'] = $select['DEAL'];
        $batch['deal_contact_data'] = ['method' => 'crm.deal.list', 'params' => $params];

        $data = CRest::callBatch($batch);
        $result = $batchResult['result']['result'];

        var_dump($result);
    </code>
</pre>