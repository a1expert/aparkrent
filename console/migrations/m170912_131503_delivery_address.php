<?php

use yii\db\Migration;

class m170912_131503_delivery_address extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve', 'delivery_address', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('reserve', 'delivery_address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170912_131503_delivery_address cannot be reverted.\n";

        return false;
    }
    */
}
