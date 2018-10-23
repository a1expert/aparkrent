<?php

use backend\models\Client;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Client */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$commonAttributes = [
    'id',
    [
        'attribute' => 'type',
        'value' => function ($model) {
            return Client::getTypeArray()[$model->type];
        },
    ],
    'phone',
    'surname',
    'name',
    'email:email',
    [
        'attribute' => 'bonus_balance',
        'value' => function ($model) {
            return (float)$model->bonus_balance;
        },
    ],
    'patronymic',
];
if ($model->type == Client::TYPE_LEGAL) {
    $nonCommonAttributes = [
        'company_name',
        'inn',
        'kpp',
        'ogrn',
        'company_residence',
        'post_in_company',
        'fio_for_paper',
        'account_number',
        'bik',
        'bank',
        'correspondent_account',
        'company_phone',
        'company_email:email',
    ];
} else {
    $nonCommonAttributes = [
        'birthday',
        'passport_series',
        'passport_number',
        'passport_date_issue:date',
        'passport_place_issue:ntext',
        'registration_place:ntext',
        'residence_place:ntext',
        'additional_phone',
        'relative_phone',
        'drive_license_series',
        'drive_license_number',
        'drive_license_issue_date:date',
    ];
}
$resultAttributes = array_merge($commonAttributes, $nonCommonAttributes);
$resultAttributes[] = [
    'attribute' => 'source',
    'value' => function ($model) {
        return $model->sourceArray[$model->source];
    }
];
\backend\assets\ClientAsset::register($this);
?>
<div class="client-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="link-selectors">
        <div data-target="#info" class="link-selector active">Общая информация</div>
        <div data-target="#files" class="link-selector">Файлы</div>
    </div>

    <div id="info" class="link-target active">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => $resultAttributes,
        ]) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->status == Client::STATUS_VERIFIED) :?>
            <?= Html::a('Отправить новый пароль', [
                    Url::to(['/client/send-new-password', 'client_id' => $model->id]),
                ], [
                    'class' => 'btn btn-primary js-new-password-button',
                ]) ?>
        <?php endif; ?>
    </div>

    <div id="files" class="link-target">
        <div class="js-files-content">
            <?= $this->render('files/_list', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="btn btn-success js-update-and-new-to-client" data-id="<?= $model->id ?>" data-url="<?= Url::to(['/client-file/create']) ?>">Добавить файлы</div>
    </div>
</div>
