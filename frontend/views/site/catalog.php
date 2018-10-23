<?php
use frontend\models\AutoMark;
use frontend\models\AutoModel;
$this->title = 'Каталог - Автопарк';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Прокат авто в Сургуте и ХМАО марок: KIA, Renault, УАЗ, Ravon и тд. Производится доставка автомобилей, все автомобили застрахованные, не старше 2-х лет.'
]);
/** @var AutoMark[] $marks */
/** @var AutoModel[] $models */
?>
<main>
<!--    <section class="catalog-brands">-->
<!--        <div class="content">-->
<!--            <div class="section-body">-->
<!--                --><?php //foreach ($marks as $mark):?>
<!--                    <div class="brand --><?//= empty($mark->activeModels) ? 'disabled' : '' ?><!--">-->
<!--                        <div class="bg-brand" style="background: --><?//= $mark->color ?><!--"></div>-->
<!--                        <i></i>-->
<!--                        <div class="body-brand">-->
<!--                            <div class="logo-brand">-->
<!--                                <img src="--><?//= $mark->logo ?><!--" alt="">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="checker" data-mark-id="--><?//= $mark->id ?><!--"></div>-->
<!--                    </div>-->
<!--                --><?php //endforeach; ?>
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
    <section class="brand-cars">
        <div class="content">
<!--            <h1 class="finded-desc">В автопарке предоставлены следующие модели данного бренда:</h1>-->
            <div class="finded-cars">
                <?= $this->render('_cars', [
                    'models' => $models,
                ]) ?>
            </div>
        </div>
    </section>
    <!--<section class="advantages-section">
        <div class="content">
            <div class="section-title">ПРЕИМУЩЕСТВА</div>
            <div class="section-body">
                <div class="advantage-block">
                    <div class="icon">
                        <div class="num">01</div>
                        <i></i>
                    </div>
                    <div class="name">Без ограничений по пробегу</div>
                </div>
                <div class="advantage-block">
                    <div class="icon">
                        <div class="num">02</div>
                        <i></i>
                    </div>
                    <div class="name">Быстрое оформление</div>
                </div>
                <div class="advantage-block">
                    <div class="icon">
                        <div class="num">03</div>
                        <i></i>
                    </div>
                    <div class="name">Доставка автомобилей</div>
                </div>
                <div class="advantage-block">
                    <div class="icon">
                        <div class="num">04</div>
                        <i></i>
                    </div>
                    <div class="name">Застрахованные автомобили, не старше 2-х лет.</div>
                </div>
            </div>
        </div>
    </section>-->
</main>

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