<?php
/** @var \backend\models\ReserveFile $file */
?>
<tr>
    <td><a target="_blank" href="<?= Yii::$app->params['frontend'] . $file->path ?>"><?= $file->name ?></a></td>
    <td><?= $file->type->title?></td>
    <td>
        <div class="btn btn-primary js-update-and-new-to-reserve" data-id="<?= $file->id ?>" data-url="/reserve-file/update">Редактировать</div>
        <div class="btn btn-danger js-delete-in-reserve" data-id="<?= $file->id ?>" data-url="/reserve-file/delete">Удалить</div>
    </td>
</tr>