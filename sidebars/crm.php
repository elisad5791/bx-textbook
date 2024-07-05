<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="list-group">
                <a class="list-group-item list-group-item-action list-group-item-primary">CRM</a>
                <a href="/crm/leads-operations" class="list-group-item list-group-item-action <?= $path == 'crm/leads-operations' ? 'list-group-item-secondary' : '' ?>">
                    Лиды - основные операции
                </a>
                <a href="/crm/deals-operations" class="list-group-item list-group-item-action <?= $path == 'crm/deals-operations' ? 'list-group-item-secondary' : '' ?>">
                    Сделки - основные операции
                </a>
                <a href="/crm/product-rows" class="list-group-item list-group-item-action <?= $path == 'crm/product-rows' ? 'list-group-item-secondary' : '' ?>">
                    Привязка товаров
                </a>
                <a href="/crm/smarts" class="list-group-item list-group-item-action <?= $path == 'crm/smarts' ? 'list-group-item-secondary' : '' ?>">
                    Смарт-процессы
                </a>
                <a href="/crm/history" class="list-group-item list-group-item-action <?= $path == 'crm/history' ? 'list-group-item-secondary' : '' ?>">
                    История лидов, сделок
                </a>    
            </div>
        </div>
        <div class="col-9 py-3" id="content">