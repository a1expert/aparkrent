<?php

/** @var \frontend\models\AutoModel[] $models */
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\AutoModel;

?>

<?php if (empty($models)): ?>
    <div class="alert-block">
        <div class="name">Свободные автомобили отсутствуют</div>
        <!--        <div class="desc">Мы подобрали Вам похожие автомобили, по вашим запросам.</div>-->
    </div>
<?php else: ?>
    <?php foreach ($models as $model): ?>
        <div class="car">
            <div class="color-block" style="background: <?= $model->mark->color ?>"></div>
            <div class="logo"></div>
            <div class="image" style="position: relative">
                <img src="<?= \common\components\FileHelper::getImageThumb($model->image, 469, 272) ?>" alt="Прокат авто <?= $model->mark->title . ' ' . $model->title ?> в Сургуте">
                <?= Html::a('Узнать подробнее', ['/site/reserve', 'id' => $model->id], ['class' => 'button']); ?></p>
            </div>
            <div class="common">
                <div class="car-name"><?= $model->mark->title . ' ' . $model->title ?></div>
                <!-- <div class="car-desc"><?= $model->description ?></div> -->
                <div class="nums-auto-buttons-wrap">
                    <div class="free-autos">
                        <?php if(($model->id == 3) || ($model->id == 11)) : ?>
                            <div class="text">Доступен с 10 декабря</div>
                        <?php endif; ?>
                        <?php if ($model->getFreeCars() != null) : ?>
                            <div class="text">Свободно автомобилей: <?= $model->getCountFree() ?></div>
                            <div class="auto-statuses">
                                <?php foreach ($model->getFreeCars() as $value) : ?>
                                    <div class="<?= $value['status'] ?>" title="<?= $value['title'] ?>"></div>
                                <?php endforeach;?>
                            </div>
                        <?php endif;?>
                    </div>
                    <?php if (!in_array(Yii::$app->controller->action->id, ['reserve', 'pay'])) :?>
                        <?php if ($model->status == \frontend\models\AutoModel::STATUS_ACTIVE) :?>
                            <a href="#reserve-modal" data-id="<?=$model->id; ?>" data-title="Забронировать <?= $model->mark->title . ' ' . $model->title ?>" class="button js-reserve-button popup-reserve">ЗАБРОНИРОВАТЬ</a>
                        <?php else:?>
                            <a href="<?= Url::to(['/site/reserve', 'id' => $model->id]) ?>" class="button disabled">ВРЕМЕННО НЕДОСТУПНО</a>
                        <?php endif;?>
                    <?php endif; ?>
                </div>

                <?php if ($model->status == AutoModel::STATUS_ACTIVE) : ?>
                    <div class="options">
                        <?php if (!empty($model->transmission)) : ?>
                            <div class="option" title="<?= $model->getTransmissionTitle() ?>">
                                <div class="option-icon">
                                    <img src="/images/equipment.png" alt="<?= $model->getTransmissionTitle() ?>">
                                </div>
                                <div class="option-desc"><?= $model->getTransmissionType() ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($model->climate_control)) : ?>
                            <div class="option" title="Климат контроль">
                                <div class="option-icon">
                                    <img src="/images/climate-control.png" alt="климат контроль">
                                </div>
                                <div class="option-desc"></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($model->conditioner)) : ?>
                            <div class="option" title="Кондиционер">
                                <div class="option-icon">
                                    <img src="/images/air-conditioner.png" alt="кондиционер">
                                </div>
                                <div class="option-desc"></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($model->heating)) : ?>
                            <div class="option" title="Подогрев сидений и руля">
                                <div class="option-icon">
                                    <img src="/images/heat.png" alt="подогрев сидений и руля">
                                </div>
                                <div class="option-desc"></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($model->audio)) : ?>
                            <div class="option" title="<?= $model->audio ?>">
                                <div class="option-icon">
                                    <img src="/images/audio.png" alt="<?= $model->audio ?>">
                                </div>
                                <div class="option-desc"></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($model->engine)) : ?>
                            <div class="option" title="<?= $model->engine ?>">
                                <div class="option-icon">
                                    <img src="/images/engine.png" alt="двигатель <?= $model->engine ?>">
                                </div>
                                <div class="option-desc"><?= $model->engine ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($model->tariffs)): ?>
                    <div class="car-tariffs">
                        <?php foreach ($model->tariffs as $tariff) :?>
                            <div class="tariff">
                                <div class="days"><?= $tariff->time ?></div>
                                <div class="price"><?= $tariff->price_for_day ?></div>
                                <div class="price-desc">руб./сутки</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if($model->id == 9) : ?>
                    <!-- <div class="car-gallery">
                        <a data-fancybox="car-gallery-<?= $model->id; ?>" href="/images/cars-main/9/foto-speredi.jpg">
                            <div class="item" style="background-image: url('/images/cars-main/9/foto-speredi.jpg');"></div>
                        </a>
                        <a data-fancybox="car-gallery-<?= $model->id; ?>" href="/images/cars-main/9/foto-s-boku.jpg">
                            <div class="item" style="background-image: url('/images/cars-main/9/foto-s-boku.jpg');"></div>
                        </a>
                        <a data-fancybox="car-gallery-<?= $model->id; ?>" href="/images/cars-main/9/foto-salona.jpg">
                            <div class="item" style="background-image: url('/images/cars-main/9/foto-salona.jpg');"></div>
                        </a>
                    </div> -->
                <?php else : ?>
                    <!-- <div class="car-gallery">
                        <div class="item item-empty">фото с переди</div>
                        <div class="item item-empty">фото с боку</div>
                        <div class="item item-empty">фото сзади</div>
                    </div> -->
                <?php endif; ?>

                <div class="mobile-panel">
                    <?php if (!in_array(Yii::$app->controller->action->id, ['reserve', 'pay'])) :?>
                        <?php if ($model->status == \frontend\models\AutoModel::STATUS_ACTIVE) :?>
                            <a href="tel:83462961041" class="button js-reserve-button">ЗАБРОНИРОВАТЬ</a>
                        <?php else:?>
                            <a href="tel:83462961041" class="button disabled">ВРЕМЕННО НЕДОСТУПНО</a>
                        <?php endif;?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>