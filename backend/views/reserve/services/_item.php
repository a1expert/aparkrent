<?php
/**
 * Created at 10.10.2017 15:03
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var Reserve $model
 */

use backend\models\AdditionalService;
use backend\models\Reserve;
use backend\models\ReserveAdditionalService;
use yii\helpers\Url;

?>
<tr>
    <?php if ($keyServices->additionalService->type == AdditionalService::TYPE_DELIVERY):?>
        <?php if ($keyServices->delivery_type == ReserveAdditionalService::DELIVERY_TO_CLIENT):?>
            <td>Доставка - <?= $keyServices->additionalService->title ?></td>
            <td><?= $keyServices->address ?></td>
            <td><?= $keyServices->additionalService->price ?></td>
        <?php else: ?>
            <td>Возврат - <?= $keyServices->additionalService->title ?></td>
            <td><?= $keyServices->address ?></td>
            <td><?= $keyServices->additionalService->price ?></td>
        <?php endif; ?>
    <?php elseif ($keyServices->additionalService->type == AdditionalService::TYPE_WASH): ?>
        <td><?= $keyServices->additionalService->title ?></td>
        <td>---</td>
        <td><?= $keyServices->additionalService->price ?></td>
    <?php else:?>
        <td><?= $keyServices->additionalService->title ?></td>
        <td>---</td>
        <td><?= $model->getDaysForAdditional() * $keyServices->additionalService->price ?></td>
    <?php endif; ?>
    <td>
        <div class="btn btn-danger js-delete-in-reserve" data-id="<?= $keyServices->id ?>" data-url="<?= Url::to(['/reserve/delete-service']) ?>">Удалить</div>
    </td>
</tr>
