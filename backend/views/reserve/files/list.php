<?php use yii\helpers\Url;

if (!empty($model->files)) :?>
    <h2>Файлы</h2>
    <table class="table">
        <tr>
            <th>Название</th>
            <th>Тип</th>
            <th></th>
        </tr>
        <?php foreach ($model->files as $file) :?>
            <?= $this->render('_item', [
                'file' => $file,
            ]) ?>
        <?php endforeach; ?>
    </table>
<?php endif; ?>