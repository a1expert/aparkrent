<?php
if (!empty($model->children)) :?>
    <h2>Доп счета</h2>
    <table class="table">
        <tr>
            <th>Услуга</th>
            <th>Сумма</th>
            <th>Дата с</th>
            <th>Дата по</th>
            <th>Статус оплаты</th>
            <th></th>
        </tr>
        <?php foreach ($model->children as $child) :?>
            <?= $this->render('_item', [
                'child' => $child,
            ]) ?>
        <?php endforeach; ?>
    </table>
<?php endif; ?>