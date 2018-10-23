<?php

use yii\db\Migration;

class m170920_090619_delete_useless_columns extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('reserve', 'date_to');
        $this->dropColumn('reserve', 'date_from');
    }

    public function safeDown()
    {
        $this->addColumn('reserve', 'date_to', $this->integer());
        $this->addColumn('reserve', 'date_from', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170920_090619_delete_useless_columns cannot be reverted.\n";

        return false;
    }
    */
}
