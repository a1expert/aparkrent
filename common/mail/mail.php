<?php
/** @var \frontend\forms\CallbackForm $form */
?>
<div>-------------------------------------------------------------</div>
<div>Имя: <?= $form->name ?></div>

<div>Email: <?= $form->email ?></div>

<?php if ($form->message != null): ?>
    <div>Сообщение: <?= $form->message ?></div>
<?php endif; ?>

<div>-------------------------------------------------------------</div>