<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <?php if (YII_ENV_PROD) : ?>
        <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter50244085 = new Ya.Metrika2({
                    id:50244085,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/50244085" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
        <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TMNN3RJ');</script>
<!-- End Google Tag Manager -->
<!-- VK Comments -->
    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?160"></script>
    <script type="text/javascript">
        VK.init({apiId: 6816336, onlyWidgets: true});
    </script>
<!-- End VK Comments -->
        <?php endif; ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <!--[if lt IE 10]>
            <link rel="stylesheet" href="/reject/reject.css" media="all" />
            <script type="text/javascript" src="/reject/reject.min.js"></script>
        <![endif]-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <meta name="yandex-verification" content="44e4d6854522f050" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="shortcut icon" type="image/png" href="/images/favicon.png?v=3">
        <?php $this->head() ?>

    </head>
    <body>
        <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TMNN3RJ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <?php $this->beginBody() ?>
            <div class="container">
                <?= $this->render('header') ?>
                <?= $content ?>
                <?= $this->render('footer'); ?>
            </div>
            <?= $this->render('modals') ?>
           

        <?php $this->endBody() ?>
        <?php if (YII_ENV_PROD) : ?>
            <link rel="stylesheet" href="https://cdn.envybox.io/widget/cbk.css">
            <script type="text/javascript" src="https://cdn.envybox.io/widget/cbk.js?wcb_code=a19293a448b78babee4efd9ac65acb22" charset="UTF-8" async></script>
        <?php endif; ?>
    </body>
</html>
<?php
$this->endPage() ?>
