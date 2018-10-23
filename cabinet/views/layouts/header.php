<header>
	<section class="login">
		<div class="content">
			<div class="login_group">
                <?php if (Yii::$app->user->isGuest) :?>
                    <a href="<?= Yii::$app->params['cabinet'] . '/site/index' ?>" class="login"><img src="/images/logout.png" alt=""> Личный кабинет </a>
                <?php else: ?>
                    <a href="<?= Yii::$app->params['cabinet'] . '/site/index' ?>" class="login">
                        <?= Yii::$app->user->identity->client->getNameAndInitials() ?>
                    </a>
                    <a href="<?= Yii::$app->params['cabinet'] . '/user/logout' ?>" class="login">Выход <img src="/images/logout.png" alt=""></a>
                <?php endif; ?>
			</div>
		</div>
	</section>
	<div class="content">
		<a href="<?= Yii::$app->params['frontend'] ?>" class="logo"></a>
		<nav>
			<a href="<?= Yii::$app->params['frontend'] . '/site/catalog' ?>">Каталог</a>
			<a href="<?= Yii::$app->params['frontend'] . '/site/jobs' ?>">Услуги</a>
			<a href="<?= Yii::$app->params['frontend'] . '/site/conditions' ?>">Условия</a>
			<a href="<?= Yii::$app->params['frontend'] . '/site/contacts' ?>">Контакты</a>
		</nav>
		<div class="right">
			<div class="social">
				<a href="" class="wa"></a>
				<a href="" class="viber"></a>
				<a href="" class="vk"></a>
			</div>
			<a href="tel:88005506041" class="phone"><i></i>+7 (3462) 96-10-41</a>
			<div class="hamburger hamburger--boring">
				<div class="hamburger-box">
					<div class="hamburger-inner"></div>
				</div>
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
			<a href="<?= Yii::$app->params['frontend'] ?>">Главная</a>
            <a href="<?= Yii::$app->params['frontend'] . '/site/catalog' ?>">Каталог</a>
            <a href="<?= Yii::$app->params['frontend'] . '/site/jobs' ?>">Услуги</a>
            <a href="<?= Yii::$app->params['frontend'] . '/site/conditions' ?>">Условия</a>
            <a href="<?= Yii::$app->params['frontend'] . '/site/contacts' ?>">Контакты</a>
		</nav>
		<a href="tel:88005506041" class="phone"><i></i>+7 (3462) 96-10-41</a>
	</div>
</menu>