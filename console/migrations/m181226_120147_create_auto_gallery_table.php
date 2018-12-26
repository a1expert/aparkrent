<?php

use yii\db\Migration;

/**
 * Handles the creation of table `model_gallery`.
 */
class m181226_120147_create_auto_gallery_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('model_gallery', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer(),
            'photo' => $this->text(),
        ]);

        $this->addForeignKey('fk-gallery-model', 'model_gallery', 'model_id', 'auto_model', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-gallery-model', 'model_gallery');
        $this->dropTable('model_gallery');
    }
}
