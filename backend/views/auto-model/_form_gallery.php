<h3>Галерея:</h3>
<label title="Upload image file" for="inputPostersImage" class="btn btn-primary button-gallery">
    <input type="file" accept="image/*" id="inputPostersImage" class="hide gallery-uploader" multiple="multiple"">
    Добавить
</label>
<div class="gallery main">
    <?php if (!empty($existing_gallery)): ?>
        <?php foreach ($existing_gallery as $item): ?>
            <div class="js-gallery-item">
                <div class="img-wrap">
                    <img class="js-img" src="<?= Yii::$app->params['frontend'] . $item->photo; ?>"/>
                    <input type="text" class="hide filename" name="ModelGallery[arrayImages][]"
                           value="<?= $item->photo ?>">
                </div>
                <div class="text-wrap">
                    <button>Удалить</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>