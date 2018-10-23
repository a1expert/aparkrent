<?php
use frontend\assets\MapAsset;

$this->title = 'Контакты - Автопарк';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Контактные данные проката авто в Автопарке по Сургуту и ХМАО. Позвонить по номеру: +7 (3462) 96-10-41'
]);
MapAsset::register($this);
?>
<main>
    <section class="contacts-page">
        <div id="map"></div>
        <div class="content">
            <div class="block">
                <h1 class="title">КОНТАКТНЫЕ ДАННЫЕ</h1>
                <div itemscope="" itemtype="http://schema.org/Organization">
                <div class="contacts">
                    <div class="contact-block">
                        <i class="location"></i>
                        <div class="info">
                            <div itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
                            <div class="name">МЕСТОРАСПОЛОЖЕНИЕ</div>
                            <div itemprop="streetAddress" data-clipboard-text="ул. Югорский тракт 1, к.1" class="desc js-copy-buffer">ул. Югорский тракт 1, к.1</div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-block">
                        <i class="phone"></i>
                        <div class="info">
                            <div class="name">ТЕЛЕФОН</div>
                            <a itemprop="telephone" href="tel:83462961041" class="desc">+7 (3462) 96-10-41</a>
                        </div>
                    </div>
                    <div class="contact-block">
                        <i class="email"></i>
                        <div class="info">
                            <div class="name">ЭЛЕКТРОННАЯ ПОЧТА</div>
                            <div itemprop="email" data-clipboard-text="info@aparkrent.ru" class="desc js-copy-buffer">info@aparkrent.ru</div>
                        </div>
                    </div>
                </div>
                </div>
                <a target="_blank" href="/pdf/company_card.pdf" class="button m">Реквизиты</a>
                <div class="button popup" href="#callback-modal">ОБРАТНАЯ СВЯЗЬ</div>
                <div class="social-block">
                    <div class="name">МЫ В СОЦ. СЕТЯХ</div>
                    <div class="social">
                        <a title="WhatsApp" href="whatsapp://send?phone=+79224165611" class="wa"></a>
                        <a title="Viber" href="viber://chat?number=+79224165611" class="viber"></a>
                        <a href="https://vk.com/aparkrent" target="_blank" class="vk"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

