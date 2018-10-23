<?php
/**
 * Created at 06.10.2017 15:14
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var Fine $fine
 */
use backend\models\Fine;
use yii\helpers\Url;

?>
<tr>
    <?php if ($fine->image != null) :?>
        <td><a target="_blank" href="<?= Yii::$app->params['frontend'] . $fine->image ?>"><?= $fine->resolution_number ?></a></td>
    <?php else: ?>
        <td><?= $fine->resolution_number ?></td>
    <?php endif; ?>
    <td><?= $fine->paragraph ?></td>
    <td><?= $fine->date != null ? Yii::$app->formatter->asDate($fine->date) : 'Не указана'?></td>
    <td><?= $fine->invoice->price ?></td>
    <td>
        <?= $fine->invoice->paid_at == null ? 'Не оплачено' : 'Оплачено' ?>
        <?php if ($fine->invoice->paid_at == null) :?>
            <div class="green table-button js-set-pay" data-url="<?= Url::to(['/invoice/set-pay', 'id' => $fine->invoice->id]) ?>">Оплатить</div>
        <?php else: ?>
            <div class="red table-button js-return-pay" data-url="<?= Url::to(['/invoice/return-pay', 'id' => $fine->invoice->id]) ?>">Отменить</div>
        <?php endif; ?>
    </td>
    <td>
        <div class="btn btn-primary js-update-and-new-to-reserve" data-id="<?= $fine->id ?>" data-url="/fine/update">Редактировать</div>
        <div class="btn btn-danger js-delete-in-reserve" data-id="<?= $fine->id ?>" data-url="/fine/delete">Удалить</div>
    </td>
</tr>