<header>
	<div class="content">
		<a href="<?= \yii\helpers\Url::to(['/']) ?>" class="logo"></a>
		<nav>
			<a href="<?= \yii\helpers\Url::to(['/site/catalog']) ?>">Автомобили</a>
			<a href="<?= \yii\helpers\Url::to(['/site/jobs']) ?>">Услуги</a>
			<a href="<?= \yii\helpers\Url::to(['/site/conditions']) ?>">Условия</a>
			<a href="<?= \yii\helpers\Url::to(['/site/contacts']) ?>">Контакты</a>
		</nav>
		<div class="right">
			<a href="tel: 83462961041" class="phone"><i></i>+7 (3462) 96-10-41</a>
		</div>
		<div class="hamburger hamburger--boring">
			<div class="hamburger-box">
				<div class="hamburger-inner"></div>
			</div>
		</div>
	</div>
</header>

<menu class="mobile-menu">
	<div class="hamburger hamburger--boring">
		<div class="hamburger-box">
			<div class="hamburger-inner"></div>
		</div>
	</div>
	<div class="wrapper">
		<nav>
			<a href="<?= \yii\helpers\Url::to(['/']) ?>">Главная</a>
			<a href="<?= \yii\helpers\Url::to(['/site/catalog']) ?>">Автомобили</a>
			<a href="<?= \yii\helpers\Url::to(['/site/jobs']) ?>">Услуги</a>
			<a href="<?= \yii\helpers\Url::to(['/site/conditions']) ?>">Условия</a>
			<a href="<?= \yii\helpers\Url::to(['/site/contacts']) ?>">Контакты</a>
		</nav>
		<a href="tel:83462961041" class="phone"><i></i>+7 (3462) 96-10-41</a>
		<div class="social">
			<a title="WhatsApp" href="whatsapp://send?phone=+79224165611"  class="wa"></a>
			<a title="Viber" href="viber://chat?number=+79224165611"  class="viber"></a>
			<a href="https://vk.com/aparkrent" target="_blank" class="vk"></a>
		</div>
	</div>
</menu>