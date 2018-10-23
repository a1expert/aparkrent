<?php

use yii\db\Migration;

class m171017_105542_add_column_paid_at_to_reserve_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve', 'paid_at', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('reserve', 'paid_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171017_105542_add_column_paid_at_to_reserve_table cannot be reverted.\n";

        return false;
    }
    */
}
