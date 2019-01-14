<?php

use common\components\FileHelper;
use frontend\assets\ReserveAsset;
use frontend\forms\ReserveForm;
use frontend\helpers\SeoHelper;
use frontend\models\AdditionalService;
use yii\widgets\ActiveForm;

$reserve = new ReserveForm();

$seo = SeoHelper::getTitleMetaForAutoById($model);
$this->title = $seo[SeoHelper::TITLE];
$this->registerMetaTag(['name' => 'description', 'content' => $seo[SeoHelper::META_TAG]]);
ReserveAsset::register($this);

/** @var \frontend\models\AutoModel $model */
?>

<main class="car-view">
	<section class="car-view">
		<div class="section-title">Прокат <?= $model->mark->title ?> <?= $model->title ?> в Сургуте</div>
		<div class="content">
			<div class="price-and-booking">
				<div class="car-tariffs-wrap">
					<div class="car-tariffs__head">
<!--						<label>-->
<!--							 В нейм вставить id  -->
<!--							<input type="radio" checked name="toggle-price"> -->
<!--							<div class="text">-->
<!--								Оплата по часам-->
<!--							</div>-->
<!--						</label>-->
<!--						<label>-->
<!--							<input type="radio" name="toggle-price"> -->
<!--							<div class="text">-->
<!--								Оплата по дням-->
<!--							</div>-->
<!--						</label>-->
					</div>
                    <?php if (!empty($model->tariffs)): ?>
                        <div class="car-tariffs-wrap">
                            <div class="car-tariffs__head">
                                <!--<label>
                                     В нейм вставить id
                                    <input type="radio" checked name="toggle-price">
                                    <div class="text">
                                        Оплата по часам
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="toggle-price">
                                    <div class="text">
                                        Оплата по дням
                                    </div>
                                </label>-->
                            </div>
                            <div class="car-tariffs">
                                <?php foreach ($model->tariffs as $tariff) :?>
                                    <div class="tariff">
                                        <div class="days"><?= $tariff->time ?></div>
                                        <div class="price"><?= $tariff->price_for_day ?></div>
                                        <div class="price-desc">руб./сутки</div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
					<!--<div class="car-tariffs">
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
					</div>-->
				</div>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'reserve-page'],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validationUrl' => ['/reserve/validate'],
                ]) ?>
					<div class="inputs-wrap">
                        <?= $form->field($reserve, 'model_id')->hiddenInput(['value' => $model->id])->label(false); ?>
                        <?= $form->field($reserve, 'price')->hiddenInput(['value' => 0, 'class' => 'js-price-input'])->label(false); ?>
                        <?= $form->field($reserve, 'name')->textInput(['placeholder' => 'Ваше имя'])->label(false); ?>
<!--						<div class="form-group"><select  placeholder="Тип аренды"><option value="">da</option></select></div>-->
                        <?= $form->field($reserve, 'phone')->textInput(['class' => 'js-phone-mask', 'placeholder' => 'Телефон'])->label(false); ?>
                        <?= $form->field($reserve, 'date_reserve')->textInput(['class' => 'js-date-range-picker', 'placeholder' => 'Срок аренды'])->label(false); ?>
						<button class="button">ЗАБРОНИРОВАТЬ</button>
					</div>
					<div class="sub-options">
						<div class="head">Дополнительные опции</div>
                        <?php foreach (AdditionalService::find()->where(['type' => AdditionalService::TYPE_RENT])->all() as $rent):?>
                            <label class="check-wrap js-check">
                                <input type="hidden" name="ReserveForm[addServices][<?= $rent->id ?>]" value="0">
                                <input type="checkbox">
                                <div class="check-block"></div>
                                <div class="text"><?= $rent->title ?></div>
                            </label>
                        <?php endforeach; ?>
                        <section class="price-section" id="price-section">
                            <div class="price">
                                Итого:
                                <strong><span class="num js-price">0</span> ₽</strong>
                            </div>
                        </section>
					</div>
                <?php ActiveForm::end() ?>
			</div>
			<div class="gallery-and-specifications">
				<div class="head">
                    <?php if (!empty($model->video)) : ?>
                        <div class="video-wrap"><?= $model->video ?></div>
                    <?php else : ?>
                        <div class="img-wrap"><img src="<?= FileHelper::getImageThumb($model->image, 469, 272) ?>" alt=""></div>
                    <?php endif; ?>
				</div>
                <?php if(!empty($model->modelGallery)) : ?>
                    <div class="gallery">
                        <div class="title">Фотографии</div>
                        <div class="items-wrap js-car-view-gallery">
                            <?php foreach ($model->modelGallery as $item) : ?>
                                <a data-fancybox="car-gallery" href="<?= $item->photo ?>" class="item"><img src="<?= $item->photo ?>" alt=""></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
				<div class="specifications">
					<div class="title">Характеристики</div>
					<div class="items-wrap">
                        <?php if (!empty($model->transmission)) : ?>
                            <div class="item">
                                <div class="icon"><img src="/images/equipment.png" alt="<?= $model->getTransmissionTitle() ?>"></div>
                                <strong>Коробка: </strong>
                                <?= $model->getTransmissionTitle() ?>
                            </div>
                        <?php endif; ?>
                        <div class="item">
                            <div class="icon"><img src="/images/climate-control.png" alt="Климат контроль"></div>
                            <strong>Климат контроль: </strong>
                            <?= $model->isExistence($model->climate_control) ?>
                        </div>
                        <div class="item">
                            <div class="icon"><img src="/images/abs.png" alt="ABS"></div>
                            <strong>ABS: </strong>
                            <?= $model->isExistence($model->abs) ?>
                        </div>
                        <div class="item">
                            <div class="icon"><img src="/images/air-conditioner.png" alt="Кондиционер"></div>
                            <strong>Кондиционер: </strong>
                            <?= $model->isExistence($model->conditioner) ?>
                        </div>
                        <div class="item">
                            <div class="icon"><img src="/images/heat.png" alt="Подогрев сидений и руля"></div>
                            <strong>Подогрев: </strong>
                            <?= $model->isExistence($model->heating) ?>
                        </div>
                        <?php if (!empty($model->audio)) : ?>
                            <div class="item">
                                <div class="icon"><img src="/images/audio.png" alt="<?= $model->audio ?>"></div>
                                <strong><?= $model->audio ?> </strong>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($model->engine)) : ?>
                            <div class="item">
                                <div class="icon"><img src="/images/engine.png" alt="Двигатель <?= $model->engine ?>"></div>
                                <strong>Мощность: </strong>
                                <?= $model->engine ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($model->consumption)) : ?>
                            <div class="item">
                                <div class="icon"><img src="/images/car-oil.png" alt="Расход"></div>
                                <strong>Расход: </strong>
                                <?= $model->consumption ?>
                            </div>
                        <?php endif; ?>
                        <div class="item">
                            <div class="icon"><img src="/images/chassis.png" alt="Привод <?= $model->getDriveUnit() ?>"></div>
                            <strong>Привод: </strong>
                            <?= $model->getDriveUnit() ?>
                        </div>
					</div>
				</div>
			</div>
			<div class="text-info-wrap">
				<div class="head">
					<label><input type="radio" name="car-view-radio" checked value="reviews"><div class="title">Отзывы</div></label>
					<label><input type="radio" name="car-view-radio" value="conditions"><div class="title">Условия</div></label>
					<label><input type="radio" name="car-view-radio" value="questions-and-answers"><div class="title">Вопросы и ответы</div></label>
					<label><input type="radio" name="car-view-radio" value="about-car"><div class="title">О машине</div></label>
				</div>
				<div class="body js-toggle-info-body">
					<article class="reviews active">
                        <div id="vk_comments"></div>
                        <script type="text/javascript">
                            VK.Widgets.Comments("vk_comments", {limit: 5, width: "532", attach: "photo"});
                        </script>
					</article>
					<article class="conditions">
						<ul>
							<li>Возраст арендатора - не менее <strong>23 лет</strong></li>
							<li>Общий стаж вождения - не менее <strong>2 лет</strong></li>
							<li>Водительское удостоверение <strong>категории “B”</strong></li>
							<li>Российский паспорт</li>
						</ul>
					</article>
					<article class="questions-and-answers">
						<div class="faq-block">
							<div class="faq-head">Необходимо ли вносить залог?</div>
							<div class="faq-body">Идейные соображения высшего порядка, а также укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Идейные соображения высшего порядка, а также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент проверки форм развития.</div>
						</div>
						<div class="faq-block">
							<div class="faq-head">Время оформления договора</div>
							<div class="faq-body">Идейные соображения высшего порядка, а также укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Идейные соображения высшего порядка, а также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент проверки форм развития.</div>
						</div>
						<div class="faq-block">
							<div class="faq-head">Формы оплаты</div>
							<div class="faq-body">Идейные соображения высшего порядка, а также укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Идейные соображения высшего порядка, а также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, сооа также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент па также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент птветствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент проверки форм развития.</div>
						</div>
					</article>
					<article class="about-car">
                        <p><?= $model->description ?></p>
					</article>
				</div>
			</div>
		</div>
	</section>
</main>