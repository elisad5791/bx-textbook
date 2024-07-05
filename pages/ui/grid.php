<h1>Гриды</h1>

<h4>Пример простого грида</h4>
<pre>
    <code>
        use Bitrix\Main\UserTable;
        use Bitrix\Main\Entity\Query;

        $gridId = 'managers';

        $class = UserTable::getEntity();
        $query = new Query($class);
        $query->registerRuntimeField(
            'FULLNAME',
            [
                'data_type' => 'string',
                'expression' => ['CONCAT(%s, " ", %s)', 'NAME', 'LAST_NAME'],
            ]
        );
        $query->registerRuntimeField(
            'LEAD',
            [
                'data_type' => 'Bitrix\Crm\LeadTable',
                'reference' => ['=this.ID' => 'ref.ASSIGNED_BY_ID'],
                'join_type' => 'INNER'
            ]
        );
        $query->registerRuntimeField(
            'LEADCOUNT',
            [
                'data_type' => 'integer',
                'expression' => ['COUNT(%s)', 'LEAD.ID'],
            ]
        );

        $select = [
            'ID',
            'FULLNAME',
            'LEADCOUNT'
        ];
        $order = ['ID' => 'ASC'];
        $query->setSelect($select)->setOrder($order);
        $data = $query->exec()->fetchAll();

        $rows = [];
        foreach ($data as $user) {
            $rows[] = ['columns' => $user];
        }
        $count = count($rows);

        $columns = [
            ['id' => 'ID', 'name' => 'ID', 'default' => true],
            ['id' => 'FULLNAME', 'name' => 'ФИО', 'default' => true],
            ['id' => 'LEADCOUNT', 'name' => 'Количество лидов', 'default' => true]
        ];

        $APPLICATION->includeComponent(
            "bitrix:main.ui.grid",
            "",
            [
                'AJAX_ID' => CAjax::getComponentId('bitrix:main.ui.grid', '.default', ''),
                'AJAX_MODE' => 'Y',
                'AJAX_OPTION_HISTORY' => 'N',
                'AJAX_OPTION_JUMP' => 'N',
                'GRID_ID' => $gridId,
                'COLUMNS' => $columns,
                'ROWS' => $rows,
                'TOTAL_ROWS_COUNT' => $count,
                'SHOW_CHECK_ALL_CHECKBOXES' => false,
                'SHOW_ROW_CHECKBOXES' => false,
                'SHOW_SELECTED_COUNTER' => false
            ]
        );
    </code>
</pre>

<p>Вид полученной таблицы:</p>
<p><img src="/images/grid.png" alt=""></p>