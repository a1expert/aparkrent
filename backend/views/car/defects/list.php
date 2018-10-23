<?php

/** @var \backend\models\Car $model */

use yii\helpers\Url;

if (!empty($model->defects)) :?>
    <h2>Дефекты</h2>
    <table class="table">
        <tr>
            <th>Место</th>
            <th>Размер</th>
            <th>Степень</th>
            <th>Ущерб</th>
            <th></th>
        </tr>
        <?php foreach ($model->defects as $defect) :?>
            <?= $this->render('_item', [
                'defect' => $defect,
            ]) ?>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<div class="btn btn-success js-add-defect-to-car" data-url="<?= Url::to(['/car/add-defect', 'car_id' => $model->id]) ?>">Добавить дефект</div>
