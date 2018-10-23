<?php
use frontend\models\Faq;

$this->title = 'Условия - Автопарк';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Услуги по прокату авто в Сургуте и ХМАО, доставки и мойка автомобиля, аренда дополнительного оборудования.'
]);
?>
<main>
	<section class="conditions-section">
        <div class="content">
            <div class="blocks">
                <div class="condition-block">
                    <h1 class="title">ТРЕБОВАНИЯ К АРЕНДАТОРУ</h1>
                    <div class="items">
                        <div class="item">
                            <i class="ic11"></i>
                            <div class="name">Минимальный возраст</div>
                        </div>
                        <div class="item">
                            <i class="ic12"></i>
                            <div class="name">Минимальный стаж</div>
                        </div>
                    </div>
                </div>
                <div class="condition-block">
                    <div class="title">НЕОБХОДИМЫЕ ДОКУМЕНТЫ</div>
                    <div class="items">
                        <div class="item">
                            <i class="ic13"></i>
                            <div class="name">Паспорт</div>
                        </div>
                        <div class="item">
                            <i class="ic14"></i>
                            <div class="name">Водительское удостоверение</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="faq-page">
        <div class="content">
            <?php foreach (Faq::find()->orderBy('sort')->all() as $faq): ?>
                <div class="faq-block">
                    <div class="faq-head"><?= $faq->sort . '. ' . $faq->question ?><i></i></div>
                    <div class="faq-body"><?= $faq->answer ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?= $this->render('_callback') ?>

<section class="contacts-section">
	<div class="contacts-general">
		<div class="content">
			<div class="section-title">Наши контакты</div>
			<div class="section-body">
				<div class="blocks">
					<div class="block">
						<i></i>
						<div class="name">телефон</div>
						<a href="tel:83462961041" class="desc">+7 (3462) 96-10-41</a>
					</div>
					<div class="block">
						<i></i>
						<div class="name">месторасположение</div>
						<div data-clipboard-text="ул. Югорский тракт 1, к.1" class="desc js-copy-buffer">ул. Югорский тракт 1, к.1</div>
					</div>
					<div class="block">
						<i></i>
						<div class="name">ЭЛЕКТРОННЫЙ АДРЕС</div>
						<div data-clipboard-text="info@aparkrent.ru" class="desc js-copy-buffer">info@aparkrent.ru</div>
					</div>
				</div>
				<div class="social">
					<a title="WhatsApp" href="whatsapp://send?phone=+79224165611" class="wa"></a>
					<a title="Viber" href="viber://chat?number=+79224165611" class="viber"></a>
					<a href="https://vk.com/aparkrent" target="_blank" class="vk"></a>
				</div>
			</div>
		</div>
	</div>
	<div id="map"></div>
</section>