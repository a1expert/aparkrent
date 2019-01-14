<?php
use frontend\models\AdditionalService;
use frontend\models\AdditionalServiceType;

$this->title = 'Услуги - Автопарк';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Условия по прокату авто в Сургуте и ХМАО: возраст и стаж арендатора, необходимые документы. Все авто застрахованы по договорам ОСАГО и КАСКО.'
]);
/**
 * @var AdditionalService[] $wash
 * @var AdditionalService[] $expressWash
 * @var AdditionalService[] $rentType
 */
?>
<main>
 <!-- 	<section class="page-banner jobs-banner">
		<div class="content">
			<h1>УСЛУГИ</h1>
		</div>
	</section> -->
	<section class="jobs-section">
		<div class="content">
			<div class="wrapper">
				<div class="block-wrapper">
					<div class="block">
						<div class="image">
							<i class="ic25"></i>
						</div>
						<div class="title">доставка автомобиля</div>
                        <?php if(!empty($deliveryType)) : ?>
                            <div class="locations">
                                <?php foreach ($deliveryType as $delivery):?>
                                    <div class="location"><span><?= $delivery->title ?></span><span class="price"><?= number_format($delivery->price, 0, '.', ' ') ?> ₽</span></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
					</div>
				</div>
				<div class="block-wrapper">
					<div class="block">
						<div class="image">
							<i class="ic26"></i>
						</div>
                        <?php if (!empty($wash)) : ?>
                            <div class="title"><?= $wash->title ?></div>
                            <div class="locations">
                                <div class="location" style="text-align: center; display: block;"><span class="price"><?= number_format($wash->price, 0, '.', ' ') ?> ₽</span></div>
                            </div>
                        <?php endif; ?>
                        <?php /*if (!empty($expressWash)) : */?><!--
                            <div class="title"><?/*= $expressWash->title */?></div>
                            <div class="locations">
                                <div class="location" style="text-align: center; display: block;"><span class="price"><?/*= number_format($expressWash->price, 0, '.', ' ') */?> ₽</span></div>
                            </div>
                        --><?php /*endif; */?>
					</div>
					<div class="block">
						<div class="image">
							<i class="ic27"></i>
						</div>
						<div class="title">АРЕНДА ДОП. ОБОРУДОВАНИЯ</div>
                        <?php if (!empty($rentType)) : ?>
                            <div class="locations">
                                <?php foreach ($rentType as $rent):?>
                                    <div class="location"><span><?= $rent->title ?></span><span class="price"><?= number_format($rent->price, 0, '.', ' ') ?> ₽ / сутки</span></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
					</div>
				</div>
			</div>
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