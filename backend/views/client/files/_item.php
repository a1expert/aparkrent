<?php
/**
 * Created at 07.10.2017 13:52
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var \backend\models\ClientFile $file
 */
?>
<tr>
    <td><a target="_blank" href="<?= Yii::$app->params['frontend'] . $file->path ?>"><?= $file->name ?></a></td>
    <td>
        <div class="btn btn-primary js-update-and-new-to-client" data-id="<?= $file->id ?>" data-url="<?= \yii\helpers\Url::to(['/client-file/update']) ?>">Редактировать</div>
        <div class="btn btn-danger js-delete-in-client" data-id="<?= $file->id ?>" data-url="<?= \yii\helpers\Url::to(['/client-file/delete']) ?>">Удалить</div>
    </td>
</tr>