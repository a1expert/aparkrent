<?php

use yii\db\Migration;

/**
 * Class m181204_162136_add_drive_unit_to_auto_model
 */
class m181204_162136_add_drive_unit_to_auto_model extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('auto_model', 'drive_unit', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('auto_model', 'drive_unit');
    }
}
