<h1>ORM</h1>

<p>Реализация ORM в ядре D7 призвана абстрагировать разработчика от механики работы с таблицами на уровне запросов к БД,
  введя понятие сущности и поля сущности.</p>
<ul>
  <li>Cущность - это таблица</li>
  <li>Поля сущности - столбцы или ссылки на другие сущности</li>
  <li>Датаменеджер - система управления данными</li>
</ul>

<p>Работа в ORM возможна только если есть класс, описывающий таблицу, с которой нужно работать.</p>
<p>Для работы с использованием ORM:</p>
<ol>
  <li>В папке <mark>bitrix</mark> нужно найти класс. Если он есть, можно работать</li>
  <li>
    Если в папке <mark>bitrix</mark> нет нужного класса:
    <ol>
      <li>Его нужно сгенерировать</li> 
      <li>Подключить класс через автозагрузку</li>
    </ol>
  </li>
</ol>

<h4>Автоматическая генерация класса</h4>
<p>Для использования генератора ORM классов перейдите на страницу <mark>Настройки -> Настройки продукта -> Настройки модулей -> Монитор производительности</mark>, модуль <mark>Монитор производительности</mark> должен быть установлен. На вкладке <mark>Генератор таблетов</mark> отметьте поле <mark>Разрешить генерацию таблетов для ORM<mark>.</p>
<p><img src="/images/generaciya_orm_classa.jpg" alt=""></p>
<p>Автоматически сгенерировать класс с описанием любой таблицы можно на странице <mark>Настройки -> Производительность -> Таблицы</mark>, в меню действий доступен пункт <mark>ORM</mark>.</p>
<p><img src="/images/orm_class.jpg" alt=""></p>

<h4>Автозагрузка классов</h4>
<p>Необходимо расположить класс в удобном месте, например <mark>/local/php_interface/lib/</mark></p>
<pre>
  <code>
    /*   /local/php_interface/lib/SomeClass.php   */

    namespace lib;

    class SomeClass
    {
        public function hello()
        {
            echo "Hello!";
        }
    }
  </code>
</pre>
<p>Автозагрузка класса прописывается в файле <mark>init.php</mark>:</p>
<pre>
  <code>
    /*   init.php   */

    use Bitrix\Main\Loader;
    Loader::registerAutoLoadClasses(null, ['lib\SomeClass' => '/local/php_interface/lib/SomeClass.php']);
  </code>
</pre>
<p>Использование класса:</p>
<pre>
  <code>
    $obj = new lib\SomeClass();
    $obj->hello();
  </code>
</pre>