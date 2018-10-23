<?php

use cabinet\models\Client;

$this->title = 'Настройки - Личный кабинет';

?>
<div class="error-summary head-message">
    <?php if ($message == '') : ?>
        Ниже вы можете увидеть ваши данные, занесенные в нашу базу. В случае ошибки вы можете исправить их и при условии успешной модерации изменения будут сохранены.
    <?php else : ?>
        <?= $message ?>
    <?php endif; ?>
</div>
<?php $form = \yii\widgets\ActiveForm::begin() ?>
<?= $form->field($client, 'id')->hiddenInput()->label(false) ?>
<div class="block_body">
    <div class="block_info">
        <?php if ($client->type == Client::TYPE_INDIVIDUAL) : ?>
            <?= $this->render('_individual', [
                'client' => $client,
                'form' => $form,
            ]) ?>
        <?php else: ?>
            <?= $this->render('_legal', [
                'client' => $client,
                'form' => $form,
            ]) ?>
        <?php endif; ?>
    </div>
    <button class="save">ОТПРАВИТЬ НА МОДЕРАЦИЮ</button>
</div>
<?php \yii\widgets\ActiveForm::end() ?>
