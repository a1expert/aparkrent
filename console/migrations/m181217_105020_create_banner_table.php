<?php

use yii\db\Migration;

/**
 * Handles the creation of table `banner`.
 */
class m181217_105020_create_banner_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('banner', [
            'id' => $this->primaryKey(),
            'title_1' => $this->string(),
            'title_2' => $this->string(),
            'image' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('banner');
    }
}
