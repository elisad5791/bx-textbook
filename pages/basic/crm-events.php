<h1>События в CRM</h1>

<h4>Пример - проверка email при добавлении и обновлении контакта</h4>

<p>Этот код размещается в <mark>local/php_interface/init.php</mark></p>
<pre>
    <code>
        include_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/events.php';
    </code>
</pre>

<p>Подключение обработчиков событий в файле <mark>events.php</mark></p>
<pre>
    <code>
        use Bitrix\Main\EventManager;

        $eventManager = EventManager::getInstance();
        $eventManager->addEventHandlerCompatible('crm', 'OnBeforeCrmContactAdd', ['Contact', 'CheckContact']);
        $eventManager->addEventHandlerCompatible('crm', 'OnBeforeCrmContactUpdate', ['Contact', 'CheckContact']);
    </code>
</pre>

<p>Код класса <mark>Contact</mark>. Класс должен быть каким-то образом загружен. Например, как описано в конце этой <a href="/pages/db/orm.php">статьи</a></p>
<pre>
    <code>
        use Bitrix\Main\Entity\Query;
        use Bitrix\Crm\ContactTable;

        class Contact
        {
            public function __construct() {}

            static public function CheckContact(&$fields)
            {
                $emailField = $fields['FM']['EMAIL'] ?? [];
                $emails = [];
                foreach ($emailField as $val) {
                    $emails[] = $val['VALUE'];
                }
                
                if (!empty($emails)) {
                    $class = ContactTable::getEntity();
                    $query = new Query($class);
                    $filter = [
                        'EMAIL' => $emails,
                    ];
                    $select = ['ID'];
                    $query->setSelect($select)->setFilter($filter)->setLimit(1);
                    $result = $query->exec()->fetchAll();

                    if (!empty($result)) {
                        $fields['RESULT_MESSAGE'] = 'Контакт с таким email уже существует';
                        return false;
                    }
                }

                return true;
            }
        }
    </code>
</pre>