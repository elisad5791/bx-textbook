<h1 class="mt-3">Смарт-процессы</h1>

<h4>Получение всех элементов смарт-процесса</h4>
<pre>
    <code>
        use Bitrix\Crm\Service\Container;

        $container = Container::getInstance();
        $factory = $container->getFactory(132);
        $processes = $factory->getItems();
        $elements = [];
        foreach ($processes as $process) {
            $elements[] = $process->getData();
        }
    </code>
</pre>

<h4>Создание нового элемента смарт-процесса</h4>
<pre>
    <code>
        $item = $factory->createItem(['TITLE' => $title, 'ASSIGNED_BY_ID' => $assigned);
        $item->setFromCompatibleData($data);
        $item->save();
    </code>
</pre>