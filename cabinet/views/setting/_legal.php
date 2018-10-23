<div class="block_input">
    <div class="block_name">
        <div class="num">1</div>
        Данные компании
    </div>
    <div class="form_group">
        <div class="input_name">Название юр. лица</div>
        <?= $form->field($client, 'company_name')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">ИНН</div>
        <?= $form->field($client, 'inn')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">КПП</div>
        <?= $form->field($client, 'kpp')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">ОГРН</div>
        <?= $form->field($client, 'ogrn')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Адрес</div>
        <?= $form->field($client, 'company_residence')->textInput()->label(false) ?>
    </div>
</div>
<div class="block_input">
    <div class="block_name">
        <div class="num">2</div>
        Данные
    </div>
    <div class="form_group">
        <div class="input_name">Фамилия</div>
        <?= $form->field($client, 'surname')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Имя</div>
        <?= $form->field($client, 'name')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Отчество</div>
        <?= $form->field($client, 'patronymic')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Должность представителя</div>
        <?= $form->field($client, 'post_in_company')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">ФИО для подписи</div>
        <?= $form->field($client, 'fio_for_paper')->textInput()->label(false) ?>
    </div>
</div>
<div class="block_input">
    <div class="block_name">
        <div class="num">3</div>
        Расчётный счёт
    </div>
    <div class="form_group">
        <div class="input_name">Номер счёта</div>
        <?= $form->field($client, 'account_number')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">БИК</div>
        <?= $form->field($client, 'bik')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Банк</div>
        <?= $form->field($client, 'bank')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Кор. счёт</div>
        <?= $form->field($client, 'correspondent_account')->textInput()->label(false) ?>
    </div>
</div>
<div class="block_input">
    <div class="block_name">
        <div class="num">4</div>
        Данные компании
    </div>
    <div class="form_group">
        <div class="input_name">Телефон</div>
        <?= $form->field($client, 'company_phone')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Электронная почта</div>
        <?= $form->field($client, 'company_email')->textInput()->label(false) ?>
    </div>
</div>