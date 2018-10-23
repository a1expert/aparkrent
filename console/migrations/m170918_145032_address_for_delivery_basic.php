<?php

use yii\db\Migration;

class m170918_145032_address_for_delivery_basic extends Migration
{
    public function safeUp()
    {
        $this->addColumn('additional_service', 'address', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('additional_service', 'address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170918_145032_address_for_delivery_basic cannot be reverted.\n";

        return false;
    }
    */
}
