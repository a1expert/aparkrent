<?php

use yii\db\Migration;

class m171110_141321_fix_for_invoices extends Migration
{
    public function safeUp()
    {
        $this->db->createCommand()->update('invoice', ['create_date' => time()])->execute();
    }

    public function safeDown()
    {
        $this->db->createCommand()->update('invoice', ['create_date' => null])->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171110_141321_fix_for_invoices cannot be reverted.\n";

        return false;
    }
    */
}
