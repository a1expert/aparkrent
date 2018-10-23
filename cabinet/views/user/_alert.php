<?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
    <div><?= $message ?></div>
<?php endforeach ?>
