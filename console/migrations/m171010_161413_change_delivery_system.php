<?php

use yii\db\Migration;

class m171010_161413_change_delivery_system extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve_additional_service', 'address', $this->string());
        $this->dropColumn('reserve', 'delivery_address');
        $this->dropColumn('reserve', 'return_address');
    }

    public function safeDown()
    {
        $this->addColumn('reserve', 'return_address', $this->string());
        $this->addColumn('reserve', 'delivery_address', $this->string());
        $this->dropColumn('reserve_additional_service', 'address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171010_161413_change_delivery_system cannot be reverted.\n";

        return false;
    }
    */
}
