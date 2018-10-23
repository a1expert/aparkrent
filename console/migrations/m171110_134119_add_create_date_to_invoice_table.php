<?php

use yii\db\Migration;

class m171110_134119_add_create_date_to_invoice_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('invoice', 'create_date', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('invoice', 'create_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171110_134119_add_create_date_to_invoice_table cannot be reverted.\n";

        return false;
    }
    */
}
