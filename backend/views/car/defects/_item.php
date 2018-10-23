<?php
/** @var \backend\models\Defect $defect */
?>
<tr>
    <td><?= $defect->place->title ?></td>
    <td><?= $defect->size->title ?></td>
    <td><?= $defect->degree->title ?></td>
    <td><?= $defect->damage->title ?></td>
    <td><div class="btn btn-danger js-delete-in-car" data-url="<?= \yii\helpers\Url::to(['/car/delete-defect', 'car_id' => $defect->car_id, 'defect_id' => $defect->id]) ?>">Удалить</div></td>
</tr>