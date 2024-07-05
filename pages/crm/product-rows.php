<h1>Привязка товаров</h1>

<h4>Привязка товаров без сохранения в каталог</h4>
<pre>
    <code>
		use Bitrix\Main\Loader;

		Loader::includeModule('crm');

		$rows = [
			['PRODUCT_NAME' => 'Страховка', 'QUANTITY' => 2, 'PRICE' => 300, 'MEASURE_CODE' => 796],
			['PRODUCT_NAME' => 'Выезд менеджера', 'QUANTITY' => 1, 'PRICE' => 100, 'MEASURE_CODE' => 796]
		]; 

		CCrmProductRow::SaveRows('D', 10, $rows);
    </code>
</pre>
<p>Коды сущностей: <mark>D</mark> - сделка, <mark>L</mark> - лид, <mark>Q</mark> - предложение.</p>
<p>Для счетов это делается иначе - товары добавляются обычным полем при добавлении или обновлении счета:</p>
<pre>
	<code class="language-php">
		CCrmInvoice::add(['ORDER_TOPIC' => 'Новый счет', 'PRODUCT_ROWS' => $rows]); 
	</code>
</pre>

<h4>Привязка товаров с сохранением их в каталог</h4>
<pre>
	<code>
		use Bitrix\Main\Loader;

		Loader::includeModule('crm');

		$product = ['NAME' => 'Товар в базе', 'QUANTITY' => 1, 'PRICE' => 100, 'MEASURE_CODE' => 796, 'CURRENCY_ID' => 'RUB'];
		$id = CCrmProduct::add($product); 

		$rows = [
		['PRODUCT_ID' => $id, 'QUANTITY' => 1]
		];
		CCrmProductRow::SaveRows('D', 10, $rows); 
	</code>
</pre>

<h4>Перенос товаров из сделки в элемент смарт-процесса</h4>
<pre>
	<code>
		use Bitrix\Main\Loader;
		use Bitrix\Crm\Service\Container;

		Loader::includeModule('crm');

		$dealId = 1;
		$arFilter = [
			'OWNER_TYPE' => 'D',
			'OWNER_ID' => $dealId,
			'CHECK_PERMISSIONS' => 'N',
		];
		$rs = \CCrmProductRow::GetList([], $arFilter);
		$products = [];
		while ($product = $rs->Fetch()) {
			$products[] = $product;
		}

		$opportunity = 0;
		foreach ($products as $product) {
			$opportunity += $product['QUANTITY'] * $product['PRICE'];
		}

		$smartId = 3;
		$itemProducts = [];
		foreach ($products as $product) {
			unset($product['ID']);
			$product['OWNER_ID'] = $smartId;
			$product['OWNER_TYPE'] = 'T91';
			$itemProducts[] = $product;
		}
		\CCrmProductRow::SaveRows('T91', $smartId, $itemProducts);

		$factory = Container::getInstance()->getFactory(145);  
		$item = $factory ->getItem($smartId);
		$item->set('OPPORTUNITY', $opportunity);
		$item->save();
	</code>
</pre>

<p>Здесь может оказаться проблемой выяснение типа смарт-процесса (значение, которое хранится в товаре по ключу <mark>OWNER_TYPE</mark>, а также является первым аргументом у метода <mark>SaveRows</mark>). В нашем случае это <mark>T91</mark>. Самый простой метод его узнать - добавить товар к элементу соответствующего смарт-процесса и посмотреть в таблице <mark>b_crm_product_row</mark>, какое значение вставляется в поле <mark>OWNER_TYPE</mark>. Таблицу можно открыть в <mark>PhpMyAdmin</mark> или через админку Битрикс <mark>Настройки->Производительнось->Таблицы</mark>. Также нужно узнать номер смарт-процесса (аргумент метода <mark>getFactory</mark>, в нашем случае 145). Для этого можно открыть карточку любого элемента смарт-процесса.</p>
<p><img src="/images/smart-product.png" alt=""></p>