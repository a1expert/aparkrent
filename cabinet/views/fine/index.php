<?php
/** @var \cabinet\models\Client $client
 *  @var \cabinet\models\Fine[] $fines
 *  @var integer $paid
 */

$this->title = 'Штрафы - Личный кабинет';

$client = Yii::$app->user->identity->client;

?>
<div class="block_body">
    <div class="button-block-table">
        <a href="<?= \yii\helpers\Url::to(['', 'paid' => 0]) ?>" class="button <?= $paid == 0 ? 'active' : '' ?>"> Неоплаченные</a>
        <a href="<?= \yii\helpers\Url::to(['', 'paid' => 1]) ?>" class="button <?= $paid == 1 ? 'active' : '' ?>">Оплаченные</a>
    </div>
    <div class="block_info">
        <table class="history_table" data-id=0>
            <tr class="title">
                <td class="">Номер Договора</td>
                <td class="">Дата нарушения</td>
                <td class="">Автомобиль</td>
                <td class="">Гос номер</td>
                <td class="">Нарушение</td>
                <td class="">Номер постановления</td>
                <td class="">Сумма</td>
            </tr>
            <?php foreach ($fines as $fine) : ?>
                <tr class="">
                    <td class="">№<?= $fine->reserve->id ?><br>
                        <!--                        <a href="">Скачать договор</a>-->
                    </td>
                    <td class=""><?= Yii::$app->formatter->asDate($fine->date, 'd-M-Y') ?></td>
                    <td class=""><?= $fine->reserve->model->mark->title . ' ' . $fine->reserve->model->title ?></td>
                    <td class=""><?= $fine->reserve->car != null ? $fine->reserve->car->number : 'Не указан' ?></td>
                    <td class=""><?= $fine->paragraph ?></td>
                    <td class="">
                        №<?= $fine->resolution_number ?> <br>
                        <?php if ($fine->image != ''): ?>
                            <a target="_blank" href="<?= Yii::$app->params['frontend'] . $fine->image?>">Скан Штрафа</a>
                        <?php endif; ?>
                    </td>
                    <td class="">
                        <?= number_format($fine->invoice->price, 0, '.', ' ') ?> <br>
                        <!--                        <a href="">Скачать квитанцию</a>-->
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>