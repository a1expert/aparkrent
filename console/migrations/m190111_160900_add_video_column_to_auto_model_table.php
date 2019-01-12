<?php

use yii\db\Migration;

/**
 * Handles adding video to table `auto_model`.
 */
class m190111_160900_add_video_column_to_auto_model_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('auto_model', 'video', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('auto_model', 'video');
    }
}
