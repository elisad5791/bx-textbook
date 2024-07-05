<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="list-group">
                <a class="list-group-item list-group-item-action list-group-item-primary">REST</a>
                <a href="/rest/start" class="list-group-item list-group-item-action <?= $path == 'rest/start' ? 'list-group-item-secondary' : '' ?>">
                    Начало работы с REST
                </a>
                <a href="/rest/batch" class="list-group-item list-group-item-action <?= $path == 'rest/batch' ? 'list-group-item-secondary' : '' ?>">
                    Метод batch
                </a>
                <a href="/rest/batch-get" class="list-group-item list-group-item-action <?= $path == 'rest/batch-get' ? 'list-group-item-secondary' : '' ?>">
                    Получение большого списка лидов
                </a>
                <a href="/rest/batch-add" class="list-group-item list-group-item-action <?= $path == 'rest/batch-add' ? 'list-group-item-secondary' : '' ?>">
                    Пакетное добавление лидов
                </a>
                <a href="/rest/batch-update" class="list-group-item list-group-item-action <?= $path == 'rest/batch-update' ? 'list-group-item-secondary' : '' ?>">
                    Пакетное обновление лидов
                </a>
                <a href="/rest/batch-delete" class="list-group-item list-group-item-action <?= $path == 'rest/batch-delete' ? 'list-group-item-secondary' : '' ?>">
                    Пакетное удаление лидов
                </a>   
                <a href="/rest/duplicates" class="list-group-item list-group-item-action <?= $path == 'rest/duplicates' ? 'list-group-item-secondary' : '' ?>">
                    Поиск дубликатов по телефону, email
                </a>    
            </div>
        </div>
        <div class="col-9 py-3" id="content">