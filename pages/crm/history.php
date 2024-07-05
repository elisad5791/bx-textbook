<h1>История лидов, сделок</h1>

<h4>Получение истории изменения статусов лидов через JS</h4>
<pre>
    <code>
        <script>
            BX.rest.callMethod(
                "crm.stagehistory.list",
                {
                    entityTypeId: 1,
                    order: { "OWNER_ID": "ASC" },
                    select: [ "OWNER_ID", "STATUS_ID" ]
                },
                function(result)
                {
                    if(result.error())
                        console.error(result.error());
                    else
                    {
                        console.dir(result.data());
                        if(result.more())
                            result.next();
                    }
                }
            );
        </script>
    </code>
</pre>

<h4>Получение истории изменения статусов лидов из истории событий</h4>
<pre>
    <code>
        use Bitrix\Main\Loader;

        Loader::includeModule('crm');

        $filter = ['ENTITY_TYPE' => 'LEAD', 'ENTITY_FIELD' => 'STAGE_ID'];
        $res = CCrmEvent::GetListEx(['ID' => 'ASC'], $filter, false, false, ['*']);

        $result = [];
        while ($item = $res->Fetch()) {
            $result[] = $item;
        }

        var_dump($result);
    </code>
</pre>

<h4>Получение истории изменения статусов лидов из таблицы истории статусов</h4>
<pre>
    <code>
        use Bitrix\Crm\History\Entity\LeadStatusHistoryTable;
        use Bitrix\Main\Entity\Query;

        $class = LeadStatusHistoryTable::getEntity();
        $query = new Query($class);
        $select = ['OWNER_ID', 'STATUS_ID'];
        $sort = ['ID' => 'ASC'];
        $filter = ['OWNER_ID' => 165961];
        $query->setSelect($select)->setOrder($sort)->setFilter($filter);
        $result = $query->exec()->fetchAll();

        var_dump($result);
    </code>
</pre>

<h4>Класс для получения истории стадий сделок</h4>
<pre>
    <code>
        use Bitrix\Crm\History\Entity\DealStageHistoryTable;
    </code>
</pre>

<h4>Получение истории изменения статусов лидов из таблицы таймлайна</h4>
<pre>
    <code>
        use Bitrix\Crm\Timeline\Entity\TimelineTable;
        use Bitrix\Main\Entity\Query;

        $class = TimelineTable::getEntity();
        $query = new Query($class);
        $select = ['TYPE_ID', 'SETTINGS', 'ASSOCIATED_ENTITY_ID'];
        $sort = ['ID' => 'ASC'];
        $filter = ['ASSOCIATED_ENTITY_TYPE_ID' => 1, 'ASSOCIATED_ENTITY_ID' => 165961, 'TYPE_ID' => 3];
        $query->setSelect($select)->setOrder($sort)->setFilter($filter);
        $result = $query->exec()->fetchAll();

        var_dump($result);
    </code>
</pre>

