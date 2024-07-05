<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="list-group">
                <a class="list-group-item list-group-item-action list-group-item-primary"> Пользователи</a>
                <a href="/basic/user-operations" class="list-group-item list-group-item-action <?= $path == 'basic/user-operations' ? 'list-group-item-secondary' : '' ?>">
                    Пользователи - основные операции
                </a>

                <a class="list-group-item list-group-item-action list-group-item-primary"> События</a>
                <a href="/basic/crm-events" class="list-group-item list-group-item-action <?= $path == 'basic/crm-events' ? 'list-group-item-secondary' : '' ?>">
                    События в CRM
                </a>
            </div>
        </div>
        <div class="col-9 py-3" id="content">