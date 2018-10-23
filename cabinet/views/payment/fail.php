<?php
/**
 * Created at 15.11.2017 16:24
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */
?>
<section class="main_page">
    <section class="success-of-payment">
        <div class="img"><img src="/images/ic-f.png" alt=""></div>
        <div class="message">Оплата не произведена</div>
        <a href="<?= \yii\helpers\Url::to(['/site/payment', 'id' => $id]) ?>" class="button">ПОВТОРИТЬ</a>
    </section>
</section>
