<?php

use backend\assets\NavAsset;

/**@var string $username \yii\web\IdentityInterface */

NavAsset::register($this);
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="/site/index">Автопарк</a>
        <button type="button" class="navbar-toggle" id="menu-toggle">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <ul class="nav navbar-right top-nav">
            <li><a class="logout" href="/site/logout"><?= $phone; ?>(Выход)</a>
            </li>
        </ul>
</nav>
