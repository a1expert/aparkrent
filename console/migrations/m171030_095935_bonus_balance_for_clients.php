<?php

use yii\db\Migration;

class m171030_095935_bonus_balance_for_clients extends Migration
{
    public function safeUp()
    {
        $this->addColumn('client', 'bonus_balance', $this->float());
    }

    public function safeDown()
    {
        $this->dropColumn('client', 'bonus_balance');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171030_095935_bonus_balance_for_clients cannot be reverted.\n";

        return false;
    }
    */
}
