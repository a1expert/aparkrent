<section class="find-result-section">
    <div class="content">
        <div class="section-title">Результаты поиска</div>
        <div class="section-body">
            <div class="finded-cars">
                <?= $this->render('_cars', [
                    'models' => $models,
                ]) ?>
            </div>
        </div>
    </div>
</section>