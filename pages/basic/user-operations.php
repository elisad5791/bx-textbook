<h1>Пользователи - основные операции</h1>

<h4>Получение отделов текущего пользователя</h4>
<pre>
    <code>
        use Bitrix\Main\UserTable;
        use Bitrix\Main\Entity\Query;

        $id = $USER->getId();
        $class = UserTable::getEntity();
        $query = new Query($class);
        $select = ['UF_DEPARTMENT'];
        $filter = ['ID' => $id];
        $query->setSelect($select)->setFilter($filter);
        $userData = $query->exec()->fetch();
        $userDeps = $userData['UF_DEPARTMENT'];
    </code>
</pre>