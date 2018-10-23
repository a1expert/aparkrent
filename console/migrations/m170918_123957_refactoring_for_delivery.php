<?php

use yii\db\Migration;

class m170918_123957_refactoring_for_delivery extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve_additional_service', 'delivery_type', $this->integer());
        $this->addColumn('reserve', 'return_date', $this->integer());
        $this->addColumn('reserve', 'return_address', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('reserve_additional_service', 'delivery_type');
        $this->dropColumn('reserve', 'return_date');
        $this->dropColumn('reserve', 'return_address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170918_123957_refactoring_for_delivery cannot be reverted.\n";

        return false;
    }
    */
}
