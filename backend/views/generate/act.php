<?php
/**
 * @var \backend\models\Reserve $reserve
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=1240, maximum-scale=1">
	<title>Акт приема-передачи автомобиля</title>
	<style type="text/css">
		table{border-collapse:collapse;border-spacing:0}td,th{border:1px solid #000;padding:0;font-size:12px}td div.ol-block p,th div.ol-block p{margin:0}.fr{float:right;margin:9px 0}.clear{clear:both}.w100{width:100px}.w100 p{margin:0}.dib{display:inline-block}.dib .tar{text-align:right}.pact-content{background:#fff;-webkit-box-sizing:border-box;box-sizing:border-box;width:100%;font-family:'Times New Roman';max-width:830px;min-height:850px;margin:0 auto;overflow:hidden}.pact-content p{font-size:12px}.pact-content p span{font-weight:600}.pact-content ul{margin:0}.pact-content ul li{font-size:12px}.pact-content .head p{text-align:center;font-size:13.3px;margin:0}.pact-content .head img{display:block;margin:0 auto;margin-bottom:10px}.pact-content h5{text-align:center;margin:0;font-weight:600;text-transform:uppercase;font-size:12px;margin-top:10px}.pact-content table.price{width:100%}.pact-content table.price tr th{font-weight:400;font-size:12px;border:1px solid #000000;padding:2px 0}.pact-content table.price tr td{border:1px solid #000000;text-align:center;font-size:12px;padding:2px 10px}.pact-content table.price tr td:nth-child(2){min-width:45%;text-align:left}.pact-content .block{width:50%;float:left}.pact-content .block .head{margin:10px 0;font-weight:600;font-size:12px;text-align:center}.pact-content .block .body{border:1px solid #000;padding:13px 9px;min-height:280px}.pact-content .block .body .top-block{min-height:135px}.pact-content .block .body .top-block p{margin:0}.pact-content .block .body .bot-block p.rank{height:15px}.pact-content .block .body .bot-block p span{width:180px;display:inline-block;border-bottom:1px solid #000}.pact-content table.act-title-table td{padding:5px 10px}.pact-content h4{margin-bottom:0;font-weight:600;font-size:14.5px}.pact-content .act-body-table{width:100%}.pact-content .act-body-table tr td{padding:5px 9px}.pact-content .act-body-table tr td:last-child{width:10%}.pact-content .act-body-table-1{width:100%}.pact-content .act-body-table-1 tr td{padding:5px 5px}.pact-content .act-body-table-1 tr td:first-child{width:5%;text-align:center}.pact-content .act-body-table-1 tr td:last-child{width:10%}.defect-table-block td,.defect-table-block th{text-align:center;height:32px;width:25%}.defect-table-block{display:inline-block;width:45%}
	</style>
</head>
<body>
	<div class="pact-module">
		<div class="pact-content">
			<div class="head">
				<img src="../logo.png" alt="">
				<p>
					Общество с ограниченной ответственностью "Бренд Сервис" <br>
					628416, Ханты-Мансийский Автономный округ - Югра АО, г. Сургут, ул.Югорский тракт 1 к.1 "Киа Центр" <br>
					Тел. +7 (3462) 96-10-41, (3462) 961-041, http://aparkrent.ru, e-mail: info@aparkrent.ru <br>
					ОГРН 1158602001843, ИНН/КПП: 8602254906/860201001
				</p>
			</div>
			<hr>
			<h5>
				Акт приема-передачи автомобиля к договору № <?= $reserve->id ?>
			</h5>
			<h5></h5>
			<p>
				<span>г.Сургут</span>
				<span style="float: right;"><?= Yii::$app->formatter->asDate('NOW', 'dd.MM.yy') ?></span>
			</p>
			<table class="act-title-table">
				<tr class="">
					<td class="">Марка, модель: <?= $reserve->car->model->getFullTitle() ?></td>
					<td class="">VIN: <?= $reserve->car->vin ?></td>
					<td class="">ГРЗ: <?= $reserve->car->number ?></td>
				</tr>
			</table>
			<h4>Комплектация автомобиля:</h4>
			<table class="act-body-table-1">
				<tr class="">
					<td class="">1</td>
					<td class="">Магнитола</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">2</td>
					<td class="">Брелок на ключах «Автопарк»</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">3</td>
					<td class="">Коврики 4 шт</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">4</td>
					<td class="">Щетка (для снега)</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">5</td>
					<td class="">Колпаки</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">6</td>
					<td class="">Аптечка</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">7</td>
					<td class="">Огнетушитель</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">8</td>
					<td class="">Домкрат</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">9</td>
					<td class="">Знак аварийной остановки</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">10</td>
					<td class="">Запасное колесо</td>
					<td class=""></td>
				</tr>
			</table>
			<h4>Чистота автомобиля:</h4>
			<table class="act-body-table">
				<tr class="">
					<td class="">Кузов автомобиля чист</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">Салон автомобиля чист</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">Багажное отделение автомобиля очищено</td>
					<td class=""></td>
				</tr>
			</table>
			<h4>Топливо:</h4>
			<table class="act-body-table">
				<tr class="">
					<td class="">Количество топлива</td>
					<td class=""></td>
				</tr>
			</table>
			<h4>Наличие необходимой документации:</h4>
			<table class="act-body-table">
				<tr class="">
					<td class="">Свидетельство о регистрации Транспортного Средства</td>
					<td class=""></td>
				</tr>
				<tr class="">
					<td class="">Ключ зажигания и отпирания дверей 1 экземпляр</td>
					<td class=""></td>
				</tr>
			</table>
            <?php if ($to_client) :?>
			    <h4>Автомобиль передан арендатору: ___час. ___мин. ___/___/_____</h4>
            <?php else: ?>
                <h4>Автомобиль передан арендодателю: ___час. ___мин. ___/___/_____</h4>
            <?php endif; ?>
			<div class="" style="margin-top: 20px;">
				<div class="fr" style="width: 50%">
					<p style="text-align: center;">
						_________________/ ООО «Бренд Сервис»/
					</p>
				</div>
				<div class="fr" style="width: 50%">
					<p style="text-align: center;">
						________________/ <?= $reserve->client->getNameAndInitials() ?>/
					</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>