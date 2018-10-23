<div class="block_input">
    <div class="block_name">
        <div class="num">1</div>
        Личные данные
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
        <div class="input_name">Дата рождения</div>
        <?= yii\jui\DatePicker::widget( [
            'dateFormat' => 'dd-MM-yyyy',
            'options' => [
                'class' => 'datepicker',
                'data' => [
                    'target' => '#client-birthday'
                ],
            ],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '1900:' . Yii::$app->formatter->asDate('NOW', 'Y'),
            ],
            'value' => $client->birthday != '' ? Yii::$app->formatter->asDate($client->birthday, 'd-M-Y') : '',
        ]) ?>
        <?= $form->field($client, 'birthday')->hiddenInput()->label(false) ?>
    </div>
</div>
<div class="block_input">
    <div class="block_name">
        <div class="num">2</div>
        Паспорт
    </div>
    <div class="group">
        <div class="form_group">
            <div class="input_name">Серия</div>
            <?= $form->field($client, 'passport_series')->textInput()->label(false) ?>
        </div>
        <div class="form_group">
            <div class="input_name">Номер</div>
            <?= $form->field($client, 'passport_number')->textInput()->label(false) ?>
        </div>
    </div>
    <div class="form_group">
        <div class="input_name">Дата выдачи</div>
        <?= yii\jui\DatePicker::widget( [
            'dateFormat' => 'dd-MM-yyyy',
            'options' => [
                'class' => 'datepicker',
                'data' => [
                    'target' => '#client-passport_date_issue'
                ],
            ],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '1900:' . Yii::$app->formatter->asDate('NOW', 'Y'),
            ],
            'value' => $client->passport_date_issue != '' ? Yii::$app->formatter->asDate($client->passport_date_issue, 'd-M-Y') : '',
        ]) ?>
        <?= $form->field($client, 'passport_date_issue')->hiddenInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Кем выдан</div>
        <?= $form->field($client, 'passport_place_issue')->textarea()->label(false) ?>
    </div>
</div>
<div class="block_input">
    <div class="block_name">
        <div class="num">3</div>
        Адреса
    </div>
    <div class="form_group">
        <div class="input_name">Место регистрации</div>
        <?= $form->field($client, 'registration_place')->textarea()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Место фактического проживания</div>
        <?= $form->field($client, 'residence_place')->textarea()->label(false) ?>
    </div>
</div>
<div class="block_input">
    <div class="block_name">
        <div class="num">4</div>
        Телефоны
    </div>
    <div class="form_group">
        <div class="input_name">Личный телефон</div>
        <?= $form->field($client, 'phone')->textInput(['disabled' => true])->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Дополнительный телефон</div>
        <?= $form->field($client, 'additional_phone')->textInput()->label(false) ?>
    </div>
    <div class="form_group">
        <div class="input_name">Родственник/друг</div>
        <?= $form->field($client, 'relative_phone')->textInput()->label(false) ?>
    </div>
</div>
<div class="block_input">
    <div class="block_name">
        <div class="num">5</div>
        Водительское удостоверение
    </div>
    <div class="group">
        <div class="form_group">
            <div class="input_name">Серия</div>
            <?= $form->field($client, 'drive_license_series')->textInput()->label(false) ?>
        </div>
        <div class="form_group">
            <div class="input_name">Номер</div>
            <?= $form->field($client, 'drive_license_number')->textInput()->label(false) ?>
        </div>
    </div>
    <div class="form_group">
        <div class="input_name">Дата выдачи</div>
        <?= yii\jui\DatePicker::widget( [
            'dateFormat' => 'dd-MM-yyyy',
            'options' => [
                'class' => 'datepicker',
                'data' => [
                    'target' => '#client-drive_license_issue_date'
                ],
            ],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '1900:' . Yii::$app->formatter->asDate('NOW', 'Y'),
            ],
            'value' => $client->drive_license_issue_date != null ? Yii::$app->formatter->asDate($client->drive_license_issue_date, 'd-M-Y') : '',
        ]) ?>
        <?= $form->field($client, 'drive_license_issue_date')->hiddenInput()->label(false) ?>
    </div>
</div>