<?php
/**
 * Created at 07.10.2017 19:43
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
\backend\assets\ClientChangeAsset::register($this);
?>
<table class="table">
    <tr>
        <td>Клиент</td>
        <td>Поле</td>
        <td>Старое значение</td>
        <td>Новое значение</td>
        <td></td>
    </tr>
    <?php foreach ($clients as $client) :?>
        <?= $this->render('_client_list', [
            'client' => $client,
        ]) ?>
    <?php endforeach; ?>
</table>
