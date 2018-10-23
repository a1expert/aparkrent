<?php
/**
 * Created at 06.10.2017 15:15
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var Reserve $model
 */
use backend\models\Reserve;
use yii\helpers\Url;

if (!empty($model->fines)) :?>
    <h2>Штрафы</h2>
    <table class="table">
        <tr>
            <th>Номер постановления</th>
            <th>Пункт ПДД</th>
            <th>Дата и время</th>
            <th>Сумма</th>
            <th>Оплата</th>
            <th></th>
        </tr>
        <?php foreach ($model->fines as $fine) :?>
            <?= $this->render('_item', [
                'fine' => $fine,
            ]) ?>
        <?php endforeach; ?>
    </table>
<?php endif; ?>