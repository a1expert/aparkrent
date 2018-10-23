<?php

use backend\assets\ReserveAsset;
use backend\models\Reserve;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Reserve */

$this->title = ($model->status == Reserve::STATUS_ACCEPTED ? 'Сделка ' : 'Заявка ') . $model->id;
ReserveAsset::register($this);
?>
<div class="reserve-view">
    <style>
        img {
            max-height: 400px;
            max-width: 400px;
        }
    </style>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="link-selectors">
        <div data-target="#info" class="link-selector active">Общая информация</div>
        <?php if ($model->status == Reserve::STATUS_ACCEPTED) :?>
            <div data-target="#fines" class="link-selector">Штрафы</div>
            <div data-target="#files" class="link-selector">Файлы</div>
            <div data-target="#reserve-children" class="link-selector">Доп счета</div>
        <?php endif; ?>
    </div>

    <div id="info" class="link-target active">
        <?= $this->render('_view', [
            'model' => $model,
        ]) ?>
    </div>
    <?php if ($model->status == Reserve::STATUS_ACCEPTED) :?>
        <div id="files" class="link-target">
            <div class="js-content">
                <?= $this->render('files/list', [
                    'model' => $model,
                ]); ?>
            </div>
            <div class="btn btn-success js-update-and-new-to-reserve" data-id="<?= $model->id ?>" data-url="<?= Url::to(['/reserve-file/create']) ?>">Добавить файл</div>
        </div>
        <div id="fines" class="link-target">
            <div class="js-content">
                <?= $this->render('fines/list', [
                    'model' => $model,
                ]); ?>
            </div>
            <div class="btn btn-success js-update-and-new-to-reserve" data-id="<?= $model->id ?>" data-url="<?= Url::to(['/fine/create']) ?>">Добавить штраф</div>
        </div>
        <div id="reserve-children" class="link-target">
            <div class="js-content">
                <?= $this->render('reserve_children/list', [
                    'model' => $model,
                ]); ?>
            </div>
            <div class="btn btn-success js-update-and-new-to-reserve" data-id="<?= $model->id ?>" data-url="<?= Url::to(['/reserve-child/create']) ?>">Добавить счет</div>
        </div>
    <?php endif; ?>
</div>
