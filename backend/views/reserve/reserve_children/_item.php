<?php
/** @var ReserveChild $child */

use backend\models\ReserveChild;
use yii\helpers\Url;

?>
<tr>
    <td><?= $child->service == null ? 'Продление' : $child->service->getFullTitle() ?></td>
    <td id="js-child-price-<?= $child->id ?>"><?= $child->invoice->price?></td>
    <td><?= $child->date_from == null ? '---' : Yii::$app->formatter->asDatetime($child->date_from, 'dd-MM-Y HH:mm') ?></td>
    <td><?= $child->date_to == null ? '---' : Yii::$app->formatter->asDatetime($child->date_to, 'dd-MM-Y HH:mm') ?></td>
    <td><?= $child->invoice->paid_at == null ? 'Не оплачен' : 'Оплачен'?>
        <?php if ($child->invoice->paid_at == null) :?>
            <div class="green table-button js-set-pay" data-url="<?= Url::to(['/invoice/set-pay', 'id' => $child->invoice->id]) ?>">Оплатить</div>
        <?php else: ?>
            <div class="red table-button js-return-pay" data-url="<?= Url::to(['/invoice/return-pay', 'id' => $child->invoice->id]) ?>">Отменить</div>
        <?php endif; ?>
    </td>
    <td>
        <?php if ($child->invoice->paid_at == null) :?>
            <div class="btn btn-primary js-count-child-price" data-id="<?= $child->id ?>" data-url="<?= \yii\helpers\Url::to(['/reserve-child/count'])?>">Пересчитать</div>
        <?php endif; ?>
        <div class="btn btn-primary js-update-and-new-to-reserve" data-id="<?= $child->id ?>" data-url="<?= \yii\helpers\Url::to(['/reserve-child/update'])?>">Редактировать</div>
        <div class="btn btn-danger js-delete-in-reserve" data-id="<?= $child->id ?>" data-url="<?= \yii\helpers\Url::to(['/reserve-child/delete'])?>">Удалить</div>
    </td>
</tr>