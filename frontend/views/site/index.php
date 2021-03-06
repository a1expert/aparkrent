<?php
use frontend\models\AutoClass;
use frontend\models\AutoMark;
use frontend\models\AutoModel;
use frontend\models\Banner;

$this->title = 'Прокат авто в Сургуте - аренда машины без водителя - «Автопарк»';
$this->registerMetaTag([
    'name' => 'description',
    'content' => ' Автопарк 🚗 - предлагает услуги по прокату авто в Сургуте. Аренда новых автомобилей, доставка авто в удобное для вас место, оформление за 15 минут. Заходите, будем рады ☎ +7 (3462) 96-10-41'
]);
/**
 * @var AutoMark[] $marks
 * @var AutoModel[] $models
 * @var AutoClass[] $classes
 * @var Banner[] $banner
 */

?>
    <main>
        <section class="index-banner">
            <div class="index-banner-slider">
                <?php if (!empty($banner)) : ?>
                    <?php foreach ($banner as $item) : ?>
                        <div class="slide" style="background: url('<?= $item->image ?>'); background-size: cover;">
                            <div class="content">
                                <div class="text">
                                    <div class='h2'><?= $item->title_1 ?></div>
                                    <div class='h3'><?= $item->title_2 ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif;?>
            </div>
			<!--noindex-->
            <div class="find-module">
                <div class="switch-button active avto" data-id=0>Автомобили</div>
                <div class="switch-button avia" data-id=1>Авиабилеты</div>
                <form class="form-groups-avto">
                    <!--<div class="form-group">
                        <select name="SearchForm[class_id]">
                            <option value="">Класс автомобиля</option>
                            <?php /*foreach ($classes as $class): */?>
                                <option value="<?/*= $class->id */?>"><?/*= $class->title */?></option>
                            <?php /*endforeach; */?>
                        </select>
                    </div>-->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <?= yii\jui\DatePicker::widget( [
                                'dateFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    'placeholder' => 'Дата аренды (с)',
                                    'autocomplete' => 'off',
                                    'readonly' => true
                                ],
                                'name' => 'SearchForm[date_from]',
                            ]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-wrapper">
                            <?= yii\jui\DatePicker::widget( [
                                'dateFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    'placeholder' => 'Дата аренды (по)',
                                    'autocomplete' => 'off',
                                    'readonly' => true
                                ],
                                'name' => 'SearchForm[date_to]',
                            ]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="button">ПОДОБРАТЬ</button>
                    </div>
                </form>
                <div class="form-groups-avia">
                    <script charset="utf-8" src="//www.travelpayouts.com/widgets/1c1dbaed5956d3238b55a32f770a9aeb.js?v=1052" async></script>
                </div>
            </div>
			<!--/noindex-->
            <div>
            </div>
        </section>
    </main>
<? if (!empty($models)) :?>
    <h1 class="section-title js-brand-cars-title">Прокат авто в сургуте: передвигайтесь по городу с комфортом</h1>
    <p class="section-title-description js-brand-cars-title-description">Новые машины и быстрое оформление всего за 10 минут</p>
    <section class="brand-cars">
        <div class="content">
            <div class="finded-cars">
                <?= $this->render('_cars', [
                    'models' => $models,
                ]) ?>
            </div>
        </div>
    </section>
<?php endif; ?>
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
		<article class="seo-text">
			<div class="content">
				<h2>Аренда авто в Сургуте – никаких ограничений в передвижении</h2>
				<p>В компании «Автопарк» вы можете взять в прокат авто и получить полную свободу передвижения по Ханты-Мансийскому и Ямало-Ненецкому округу. Это гарантия вашей мобильности: если вам предстоят регулярные поездки, вы не будете зависеть от общественного транспорта, режима работы водителя и времени суток – ваша поездка состоится в любом случае. Более того, вы сможете составить наиболее удобный для себя, для своего дела или для ситуации план перемещений.</p>
				<h3>Безопасность в движении</h3>
				<p>Вы можете быть уверены в отличном техническом состоянии арендуемого автомобиля. Мы тщательно следим за этим: каждая машина из нашего автопарка регулярно проходит ТО у официального дилера.</p>
				<p>Помимо этого, <strong>наши автомобили в обязательном порядке застрахованы:</strong> ОСАГО, КАСКО. Это означает, что беспокоиться о неприятностях, которые могут повстречаться в дороге, вам не придется.</p>
				<p>В арендованном транспортном средстве имеется все необходимое, включая полный бак бензина и покрышки по сезону. При необходимости вы можете дополнительно взять детское кресло, навигатор, видеорегистратор.</p>
				<h3>Наш автопарк</h3>
				<p>Мы предлагаем в аренду более 20 машин. Преимущественно это марки KIA - самые востребованные автомобили для передвижения в условиях города и бездорожья. Вы можете выбрать транспортное средство, лучше других отвечающее вашим запросам и ситуации.</p>
				<p>В нашем автопарке нет машин старше 3 лет. <strong>Все автомобили новые</strong>, стопроцентно исправные, чистые, ухоженные, в разных комплектациях.</p>
				<p>Мы делаем все возможное, чтобы при помощи нашей автотехники вы успели все, что запланировали.</p>
				<h3>Стоимость аренды авто</h3>
                <p>Рассчитывать время, на которое вам понадобится транспортное средство в Сургуте, следует рационально. Прокат машины на длительный срок обходится дешевле, чем кратковременная аренда. Экономия может составить до 20%.</p>
			</div>
		</article>
	</div>
	<div id="map"></div>
</section>
