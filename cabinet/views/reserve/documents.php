<?php
/**
 * Created at 13.11.2017 20:08
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var \cabinet\models\Reserve $reserve
 */
$this->title = 'Документация резерва №' . $reserve->id
?>
<div class="block_body">
    <div class="block_info">
        <table class="history_table">
            <tr class="title">
                <td>№п/п</td>
                <td>Название</td>
                <td>Тип</td>
                <td></td>
            </tr>
            <?php foreach ($reserve->files as $index => $file) : ?>
                <tr>
                    <td><?= $index+1 ?></td>
                    <td><?= $file->name ?></td>
                    <td><?= $file->type->title ?></td>
                    <td><?= \yii\helpers\Html::a('Просмотр', Yii::$app->params['frontend'] . $file->path, ['target' => '_blank'])?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
