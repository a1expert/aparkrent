<?php

use yii\db\Migration;

class m171013_105128_scan_for_fines extends Migration
{
    public function safeUp()
    {
        $this->addColumn('fine', 'image', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('fine', 'image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171013_105128_scan_for_fines cannot be reverted.\n";

        return false;
    }
    */
}
