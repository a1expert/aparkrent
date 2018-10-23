<?php

use yii\db\Migration;

class m171101_090811_counter_for_invoice extends Migration
{
    public function safeUp()
    {
        $this->addColumn('invoice', 'counter', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('invoice', 'counter');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171101_090811_counter_for_invoice cannot be reverted.\n";

        return false;
    }
    */
}
