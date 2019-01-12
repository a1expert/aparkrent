<?php
/** @var \frontend\models\AutoModel $model */
use frontend\assets\ReserveAsset;
use frontend\models\AdditionalService;
use frontend\helpers\SeoHelper;

$seo = SeoHelper::getTitleMetaForAutoById($model);
$this->title = $seo[SeoHelper::TITLE];
$this->registerMetaTag(['name' => 'description', 'content' => $seo[SeoHelper::META_TAG]]);
//$this->title = 'Бронирование ' . $model->mark->title . ' ' . $model->title .' - Автопарк ' ;
ReserveAsset::register($this);
?>
<main>
    <form class="reserve-page">
        <div class="content">
            <div class="section-title">БРОНИРОВАНИЕ АВТОМОБИЛЯ</div>
            <div class="section-body">
                <section class="price-section" id="price-section">
                    <div class="name">Итоговая стоимость аренды автомобиля</div>
                    <div class="price">
                        <div class="num js-price">0</div>
                        <input type="hidden" class="js-price-input" name="ReserveForm[price]" value="0">
                        <div class="price-desc">
                            <div class="rouble">₽</div>
                        </div>
                    </div>
                </section>
                <section class="online-pay-info">
                    <div class="info-block">
                        <div class="general-info">
                            <div class="color-block" style="background: <?= $model->mark->color ?>"></div>
                            <div class="logo"></div>
                            <div class="info">
                                <div class="image">
                                    <img id="redirect-to-main" src="<?= \common\components\FileHelper::getImageThumb($model->image, 172, 100) ?>" alt="Прокат авто <?= $model->mark->title . ' ' . $model->title ?> в Сургуте">
                                </div>
                                <div class="title"><?= $model->mark->title . ' ' . $model->title ?></div>
                            </div>
                        </div>
                        <div class="reserve-module">
                            <div class="block-general-reserve">
                                <div class="module-title">ПЕРИОД АРЕНДЫ</div>
                                <div class="module-body">
                                    <div class="inputs date-inputs">
                                        <div class="form-group">
                                            <input name="ReserveForm[date_from]" type="text" placeholder="Дата аренды (с)" readonly autocomplete="off" class="js-date from datetimepicker" value="<?= isset(\Yii::$app->request->get('SearchForm')['date_from']) ? \Yii::$app->request->get('SearchForm')['date_from'] : '' ?>">
                                        </div>
                                        <div class="form-group">
                                            <input name="ReserveForm[date_to]" type="text" placeholder="Дата аренды (по)" readonly autocomplete="off" class="js-date from datetimepicker" value="<?= isset(\Yii::$app->request->get('SearchForm')['date_to']) ? \Yii::$app->request->get('SearchForm')['date_to'] : '' ?>">
                                            <input type="hidden" name="ReserveForm[model_id]" value="<?= $model->id ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="ReserveForm[phone]" placeholder="Телефон" class="js-phone-mask">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label class="additional-parameters-switch">
                                <input type="checkbox" name="" id="">
                                <div class="check-block"></div>
                                <div class="text">Дополнительные параметры</div>
                            </label>
                            <div class="additional-parameters">
                                <div class="wrap">
                                    <div class="inputs-group-wrap">
                                        <div class="inputs">
                                            <div class="form-group">
                                                <label>Место получения автомобиля</label>
                                                <select name="ReserveForm[delivery_type]" class="js-delivery-select delivery">
                                                    <option data-address="Югорский тракт 1 к.1" value="" class="non-choice">Офис компании</option>
                                                    <?php foreach (AdditionalService::find()->where(['type' => AdditionalService::TYPE_DELIVERY])->all() as $delivery):?>
                                                        <option data-address="<?= $delivery->address ?>" value="<?= $delivery->id ?>"><?= $delivery->title ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <!--<div class="form-group">
                                                <label>Возврат автомобиля</label>
                                                <select name="ReserveForm[return_type]" class="js-delivery-select return">
                                                    <option data-address="Югорский тракт 1 к.1" value=""  class="non-choice">Офис компании</option>
                                                    <?php /*foreach (AdditionalService::find()->where(['type' => AdditionalService::TYPE_DELIVERY])->all() as $delivery):*/?>
                                                        <option data-address="<?/*= $delivery->address */?>" value="<?/*= $delivery->id */?>"><?/*= $delivery->title */?></option>
                                                    <?php /*endforeach; */?>
                                                </select>
                                            </div>-->
                                            <div class="form-group">
                                                <label>Адрес получения автомобиля</label>
                                                <input name="ReserveForm[delivery_address]" class="delivery" type="text" value="">
                                            </div>
                                            <div class="form-group js-delivery-time">
                                                <label>Время получения автомобиля</label>
                                                <?= \yii\widgets\MaskedInput::widget([
                                                    'name' => 'ReserveForm[delivery_time]',
                                                    'type' => 'text',
                                                    'value' => '',
                                                    'mask' => '99:99',
                                                    'options' => [
                                                            'autocomplete' => false,
                                                            'placeholder' => '09:00',
                                                            'class' => 'js-input-delivery-time',
                                                    ]
                                                ])?>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label>Адрес</label>
                                                <input name="ReserveForm[return_address]" class="return" type="text" value="Югорский тракт 1 к.1">
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="block-other-jobs">
                                        <div class="module-title">ДОП. ОБОРУДОВАНИЕ</div>
                                        <!--<div class="inputs">
                                            <?php /*foreach (AdditionalService::find()->where(['type' => AdditionalService::TYPE_RENT])->all() as $rent):*/?>
                                                <div class="check-other-job">
                                                    <?/*= $rent->title */?>
                                                    <input type="hidden" name="ReserveForm[addServices][<?/*= $rent->id */?>]" value="0">
                                                </div>
                                            <?php /*endforeach; */?>
                                        </div>-->
                                        <!--<div class="module-title" style="margin-top: 19px;">МОЙКА АВТО</div>
                                        <div class="inputs">
                                            <?php /*foreach (AdditionalService::find()->where(['type' => AdditionalService::TYPE_WASH])->all() as $wash):*/?>
                                                <div class="check-other-job">
                                                    <?/*= $wash->title */?>
                                                    <input type="hidden" name="ReserveForm[addServices][<?/*= $wash->id */?>]" value="0">
                                                </div>
                                            <?php /*endforeach; */?>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="button-wrap">
                    <div class="content">
                        <button>Забронировать</button>
                        <div class="error-summary"></div>
                        <div class="error-summary-reserve"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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


<div id="reserve-success" class="zoom-anim-dialog mfp-hide">
    <div id="success"></div>
</div>