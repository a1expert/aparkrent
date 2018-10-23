<?php
/**
 * Created at 07.10.2017 13:51
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 * @var \backend\models\Client $model
 */
if (!empty($model->files)) :?>
    <h2>Прикрепленные файлы</h2>
    <table class="table">
        <tr>
            <th>Название</th>
            <th></th>
        </tr>
        <?php foreach ($model->files as $file) :?>
            <?= $this->render('_item', [
                'file' => $file,
            ]) ?>
        <?php endforeach; ?>
    </table>
<?php endif; ?>