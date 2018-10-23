<?php
$this->title = 'Оплата - Автопарк';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Оплата по номеру заказа прокат авто в Сургуте и ХМАО'
]);
\frontend\assets\PayAsset::register($this);
// TODO неиспользуется, удалить при успешном переносе оплаты
?>
<main>
    <section class="online-pay">
        <div class="content">
            <h1 class="section-title">ОПЛАТА ПО НОМЕРУ ЗАКАЗА</h1>
            <div class="section-body">
                <div class="block">
                    <div class="title">Введите номер заказа</div>
                    <form class="js-find-reserve">
                        <input class="js-reserve-id" type="text" placeholder="№ Заказа">
                        <button>ПРИМЕНИТЬ</button>
                        <div class="error-summary"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>