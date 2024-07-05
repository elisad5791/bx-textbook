<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="list-group">
                <a class="list-group-item list-group-item-action list-group-item-primary">Работа с БД</a>
                <a href="/db/directs" class="list-group-item list-group-item-action <?= $path == 'db/directs' ? 'list-group-item-secondary' : '' ?>">
                    Прямые запросы к БД
                </a>
                <a href="/db/low" class="list-group-item list-group-item-action <?= $path == 'db/low' ? 'list-group-item-secondary' : '' ?>">
                    Работа с БД на низком уровне
                </a>
                <a href="/db/orm" class="list-group-item list-group-item-action <?= $path == 'db/orm' ? 'list-group-item-secondary' : '' ?>">
                    ORM
                </a>
                <a href="/db/class" class="list-group-item list-group-item-action <?= $path == 'db/class' ? 'list-group-item-secondary' : '' ?>">
                    Класс ORM-сущности
                </a>
                <a href="/db/builder-description" class="list-group-item list-group-item-action <?= $path == 'db/builder-description' ? 'list-group-item-secondary' : '' ?>">
                    Построитель запросов - описание
                </a>
                <a href="/db/builder-examples" class="list-group-item list-group-item-action <?= $path == 'db/builder-examples' ? 'list-group-item-secondary' : '' ?>">
                    Построитель запросов - примеры
                </a>
                <a href="/db/builder-aggregate" class="list-group-item list-group-item-action <?= $path == 'db/builder-aggregate' ? 'list-group-item-secondary' : '' ?>">
                    Построитель запросов - агрегатные функции
                </a>
            </div>
        </div>
        <div class="col-9 py-3" id="content">
