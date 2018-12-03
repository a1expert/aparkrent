<?php
/**
 * Created at 10.10.2017 14:41
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var \backend\models\Reserve $model
 */
?>
<?php if (!empty($model->reserveAdditionalServices) || $model->deliveryNotInWorkTime || $model->returnNotInWorkTime) :?>
    <h2>Дополнительные услуги</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Адрес</th>
                <th>Цена</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($model->deliveryNotInWorkTime): ?>
            <tr>
                <td>Доставка вне рабочее время</td>
                <td></td>
                <td>0</td>
                <td></td>
            </tr>
        <?php endif;?>
        <?php if ($model->returnNotInWorkTime): ?>
            <tr>
                <td>Возврат вне рабочее время</td>
                <td></td>
                <td>0</td>
                <td></td>
            </tr>
        <?php endif;?>
        <?php foreach ($model->reserveAdditionalServices as $keyServices) :?>
            <?= $this->render('_item', [
                'keyServices' => $keyServices,
                'model' => $model,
            ])?>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>