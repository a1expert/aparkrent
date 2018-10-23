<?php
/**
 * Created at 07.10.2017 19:45
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var \backend\models\ClientChange $change
 * @var \backend\models\Client $client
 */
use yii\helpers\Url;

?>
<tr>
    <td></td>
    <td><?= $client->getAttributeLabel($change->attribute)?></td>
    <?php if (in_array($change->attribute, ['birthday', 'passport_date_issue', 'drive_license_issue_date'])) :?>
        <td><?= Yii::$app->formatter->asDate($change->old_value, 'd-M-Y') ?></td>
        <td><?= Yii::$app->formatter->asDate($change->new_value, 'd-M-Y') ?></td>
    <?php else:?>
        <td><?= $change->old_value ?></td>
        <td><?= $change->new_value ?></td>
    <?php endif; ?>
    <td>
        <div class="btn btn-primary js-decision-change" data-url="<?= Url::to(['/client-change/accept', 'id' => $change->id]) ?>">Одобрить</div>
        <div class="btn btn-danger js-decision-change" data-url="<?= Url::to(['/client-change/reject', 'id' => $change->id]) ?>">Удалить</div>
    </td>
</tr>
