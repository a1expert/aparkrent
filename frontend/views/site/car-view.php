<?php
use frontend\assets\MapAsset;

$this->title = 'Контакты - Автопарк';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Контактные данные проката авто в Автопарке по Сургуту и ХМАО. Позвонить по номеру: +7 (3462) 96-10-41'
]);
?>

<main class="car-view">
	<section class="car-view">
		<div class="section-title">Прокат KIA RIO 2017 в Сургуте</div>
		<div class="content">
			<div class="price-and-booking">
				<div class="car-tariffs-wrap">
					<div class="car-tariffs__head">
						<label>
							<!-- В нейм вставить id  -->
							<input type="radio" checked name="toggle-price"> 
							<div class="text">
								Оплата по часам
							</div>
						</label>
						<label>
							<input type="radio" name="toggle-price"> 
							<div class="text">
								Оплата по дням
							</div>
						</label>
					</div>
					<div class="car-tariffs">
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
						<div class="tariff">
							<div class="days">1-2 дня</div>
							<div class="price">1800</div>
							<div class="price-desc">руб./сутки</div>
						</div>
					</div>
				</div>
				<form>
					<div class="inputs-wrap">
						<div class="form-group"><input placeholder="Ваше имя" type="text"></div>
						<div class="form-group"><input  placeholder="Телефон" type="text"></div>
						<div class="form-group"><select  placeholder="Тип аренды"><option value="">da</option></select></div>
						<div class="form-group"><input  placeholder="Срок аренды" type="text"></div>
						<button class="button">ЗАБРОНИРОВАТЬ</button>
					</div>
					<div class="sub-options">
						<div class="head">Дополнительные опции</div>
						<label class="check-wrap">
							<input type="checkbox">
							<div class="check-block"></div>
							<div class="text">Видеорегистратор</div>
						</label>
						<label class="check-wrap">
							<input type="checkbox">
							<div class="check-block"></div>
							<div class="text">Навигатор</div>
						</label>
						<label class="check-wrap">
							<input type="checkbox">
							<div class="check-block"></div>
							<div class="text">Детское кресло</div>
						</label>
						<div class="price">
							Итого:
							<strong><span> 1600</span> ₽</strong> 
						</div>
					</div>
				</form>
			</div>
			<div class="gallery-and-specifications">
				<div class="head">
					<!-- Одно из двух -->
					<div class="img-wrap"><img src="/images/img/thumb_5d3dd1816dc8d3c1db309bfde97c7a95_469x272.png" alt=""></div>
					<!-- <div class="video-wrap"><iframe width="100%" height="100%" src="https://www.youtube.com/embed/Gf6kNDDn6Lw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div> -->
				</div>
				<div class="gallery">
					<div class="title">Фотографии</div>
					<div class="items-wrap js-car-view-gallery">
						<div class="item"><img src="/images/img/car-view-gallery.png" alt=""></div>
						<div class="item"><img src="/images/img/car-view-gallery.png" alt=""></div>
						<div class="item"><img src="/images/img/car-view-gallery.png" alt=""></div>
						<div class="item"><img src="/images/img/car-view-gallery.png" alt=""></div>
					</div>
				</div>
				<div class="specifications">
					<div class="title">Характеристики</div>
					<div class="items-wrap">
						<div class="item">
							<div class="icon"><img src="/images/equipment.png" alt="Автоматическая коробка передач"></div>
							<strong>Коробка: </strong>
							Автомат
						</div>
						<div class="item">
							<div class="icon"><img src="/images/car-oil.png" alt="Автоматическая коробка передач"></div>
							<strong>Расход: </strong>
							12 л / 100 км
						</div>
						<div class="item">
							<div class="icon"><img src="/images/chassis.png" alt="Автоматическая коробка передач"></div>
							<strong>Привод: </strong>
							Передний
						</div>
						<div class="item">
							<div class="icon"><img src="/images/climate-control.png" alt="Автоматическая коробка передач"></div>
							<strong>Климат контроль: </strong>
							Есть
						</div>
						<div class="item">
							<div class="icon"><img src="/images/engine.png" alt="Автоматическая коробка передач"></div>
							<strong>Мощность: </strong>
							200 л.с.
						</div>
						<div class="item">
							<div class="icon"><img src="/images/abs.png" alt="Автоматическая коробка передач"></div>
							<strong>ABS: </strong>
							Есть
						</div>
					</div>
				</div>
			</div>
			<div class="text-info-wrap">
				<div class="head">
					<label><input type="radio" name="car-view-radio" checked value="reviews"><div class="title">Отзывы</div></label>
					<label><input type="radio" name="car-view-radio" value="conditions"><div class="title">Условия</div></label>
					<label><input type="radio" name="car-view-radio" value="questions-and-answers"><div class="title">Вопросы и ответы</div></label>
					<label><input type="radio" name="car-view-radio" value="about-car"><div class="title">О машине</div></label>
				</div>
				<div class="body js-toggle-info-body">
					<article class="reviews active">
						reviews
					</article>
					<article class="conditions">
						<ul>
							<li>Возраст арендатора - не менее <strong>23 лет</strong></li>
							<li>Общий стаж вождения - не менее <strong>2 лет</strong></li>
							<li>Водительское удостоверение <strong>категории “B”</strong></li>
							<li>Российский паспорт</li>
						</ul>
					</article>
					<article class="questions-and-answers">
						<div class="faq-block">
							<div class="faq-head">Необходимо ли вносить залог?</div>
							<div class="faq-body">Идейные соображения высшего порядка, а также укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Идейные соображения высшего порядка, а также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент проверки форм развития.</div>
						</div>
						<div class="faq-block">
							<div class="faq-head">Время оформления договора</div>
							<div class="faq-body">Идейные соображения высшего порядка, а также укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Идейные соображения высшего порядка, а также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент проверки форм развития.</div>
						</div>
						<div class="faq-block">
							<div class="faq-head">Формы оплаты</div>
							<div class="faq-body">Идейные соображения высшего порядка, а также укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Идейные соображения высшего порядка, а также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, сооа также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент па также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент птветствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент проверки форм развития.</div>
						</div>
					</article>
					<article class="about-car">
						<p>
							Идейные соображения высшего порядка, а также укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Идейные соображения высшего порядка, а также консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Задача организации, в особенности же сложившаяся структура организации представляет собой интересный эксперимент проверки форм развития. <br><br>
							
							Значимость этих проблем настолько очевидна, что консультация с широким активом играет важную роль в формировании форм развития. С другой стороны консультация с широким активом влечет за собой процесс внедрения и модернизации существенных финансовых и административных условий. Идейные соображения высшего порядка, а также укрепление и развитие структуры требуют от нас анализа систем массового участия.
						</p>
					</article>
				</div>
			</div>
		</div>
	</section>
</main>