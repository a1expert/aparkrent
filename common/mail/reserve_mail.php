<?php
/** @var \frontend\models\Reserve $reserve */
use frontend\models\AdditionalService;
use frontend\models\ReserveAdditionalService;

?>
<table style="background-color: #e4e7ed ;width: 100%" border="0" cellpadding="0" cellspacing="0">
    <table style="border-collapse: collapse;; width: 100%; max-width: 450px; background: #fff;
    border: 1px solid #D8D8D8; margin: 50px auto;">
        <thead>
            <th></th>
        </thead>
        <tbody>
            <tr>
                <td style="height: 150px; border: 1px solid #D8D8D8; background: #70008c;text-align: center; " colspan="2">
                    <img width="258" height="57" style="width: 258px; height: 57px; margin: 0 auto;" src="<?= \Yii::$app->request->getServerName() ?>/images/mail_logo.png" alt="" >
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 30px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0; text-align: center;font-size: 27px;
                font-weight: 600;">Поступила заявка на резерв</td>
                
            </tr>
            <!--<tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">ФИО:</td>
                <td style="padding: 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0; text-align: right;"><?/*= $reserve->client->name */?></td>
            </tr>-->
            <tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Телефон:</td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?= $reserve->client->phone ?></td>
            </tr>
            <!--<tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Почта:</td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?/*= $reserve->client->email */?></td>
            </tr>-->
            <?php if ($reserve->model != null): ?>
             <tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Модель:</td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?= $reserve->model->mark->title . ' ' . $reserve->model->title ?></td>
            </tr>
        <?php endif;?>
            <tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Дата доставки:</td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?= Yii::$app->formatter->asDatetime($reserve->delivery_date, 'php:Y-m-d') ?></td>
            </tr>
            <?php
            $delivery = ReserveAdditionalService::findOne(['reserve_id' => $reserve->id, 'delivery_type' => ReserveAdditionalService::DELIVERY_TO_CLIENT]);
            if($delivery != null):?>
            <tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Место доставки: </td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?= !empty($delivery->additionalService->title)?$delivery->additionalService->title:'Офис компании'; ?></td>
            </tr>
            <tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Точный адрес:</td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?= !empty($delivery->additionalService->address)?$delivery->additionalService->address:'Югорский тракт 1 к.1'; ?></td>
            </tr>
            <tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Время получения автомобиля: </td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?= !empty($delivery->time)?Yii::$app->formatter->asDatetime($delivery->time, 'HH:mm'):'09:00'; ?></td>
            </tr>
            <?php else: ?>
            <tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Место доставки: </td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;">Офис компании</td>
            </tr>
            <tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Время получения автомобиля: </td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;">09:00</td>
            </tr>
            <?php endif?>
            <tr>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Дата возврата:</td>
                <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?= Yii::$app->formatter->asDatetime($reserve->return_date, 'php:Y-m-d') ?></td>
            </tr>
            <?php
/*            $return = ReserveAdditionalService::findOne(['reserve_id' => $reserve->id, 'delivery_type' => ReserveAdditionalService::DELIVERY_FROM_CLIENT]);
            if($return != null):*/?><!--
                <tr>
                    <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Место возврата: </td>
                    <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?/*= $return->additionalService->title */?></td>
                </tr>
                <tr>
                    <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Точный адрес:</td>
                    <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;"><?/*= $return->additionalService->address */?></td>
                </tr>
            <?php /*else: */?>
                <tr>
                    <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;">Место возврата: </td>
                    <td style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: right;">Офис компании</td>
                </tr>
            --><?php /*endif*/?>
            <tr>
                <td style="padding:10px 20px; border: none;">Доп услуги:
                    <ul>
                        <?php if (!empty($reserve->reserveAdditionalServices)) : ?>
                            <?php foreach ($reserve->reserveAdditionalServices as $reserveAdditionalService) :
                                $service = $reserveAdditionalService->additionalService; ?>
                                <?php if ($service->type == AdditionalService::TYPE_DELIVERY) : ?>
                                <?php if ($reserveAdditionalService->delivery_type == \frontend\models\ReserveAdditionalService::DELIVERY_TO_CLIENT): ?>
                                    <li><?= 'Доставка: ' ?><span><?= number_format($service->price, 0, '.', ' ') ?>
                                            ₽</span></li>
                                <?php else: ?>
                                    <li><?= 'Возврат: ' ?><span><?= number_format($service->price, 0, '.', ' ') ?>
                                            ₽</span></li>
                                <?php endif; ?>
                            <?php elseif ($service->type == AdditionalService::TYPE_WASH): ?>
                                <li><?= $service->title ?> <span><?= number_format($service->price, 0, '.', ' ') ?>
                                        ₽</span></li>
                            <?php elseif ($service->type == AdditionalService::TYPE_RENT): ?>
                                <li><?= $service->title ?>
                                    <span><?= number_format($service->price * $reserve->daysForAdditional, 0, '.', ' ') ?>
                                        ₽</span></li>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if ($reserve->deliveryNotInWorkTime): ?>
                                <li>Доставка в нерабочее время <span>0 ₽</span></li>
                            <?php endif; ?>
                            <?php if ($reserve->returnNotInWorkTime): ?>
                                <li>Возврат в нерабочее время <span>0 ₽</span></li>
                            <?php endif; ?>
                            <?php if ($reserve->additionalHours): ; ?>
                                <li>Оплата дополнительных часов <span><?= $reserve->additionalHours * 300 ?> ₽</span>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li>Дополнительные услуги отсутствуют</li>
                        <?php endif; ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:10px 20px; border: 1px solid #D8D8D8; border-right: 0; border-left: 0;text-align: center;font-size: 20px;">
                    Итоговая цена: <span><?= $reserve->invoice->price ?> ₽</span>
                </td>
                
            </tr>
            <!--<tr>
                <td  style="padding:10px 20px; border: none;">Прикрепленные файлы:
                    <?php /*foreach ($reserve->files as $file):*/?>
                        <li><a href="<?/*= \Yii::$app->request->getServerName() . $file->path */?>"><?/*= $file->name */?></a></li>
                    <?php /*endforeach; */?>
                </td>
            </tr>-->
            <tr style="padding-top:50px;">
                <td colspan="2" style="text-align: center; padding: 25px;">
                    <a href="crm.<?= \Yii::$app->request->getServerName() ?>" style="text-decoration: none;border-radius: 30px; width: 200px; margin: 0 auto;
                    color: #fff; background: #70008c; padding: 20px 25px; display: block;">Одобрить заявку</a>
                </td>
            </tr>
        </tbody>
    </table>
 </table>
