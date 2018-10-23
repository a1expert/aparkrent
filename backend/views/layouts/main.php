<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;

use yii\helpers\Html;

AppAsset::register($this);

$phone = Yii::$app->user->identity->phone;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <div class="container-fluid">
        <?= $this->render('nav_header', ['phone' => $phone]); ?>
        <?= $this->render('sidebar'); ?>
        <div class="content">
            <?= $content ?>
        </div>

    </div>
    <div id="modal" class="mfp-hide zoom-anim-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
