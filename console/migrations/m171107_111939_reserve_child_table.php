<?php

use yii\db\Migration;

class m171107_111939_reserve_child_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('reserve_child', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'date_from' => $this->integer(),
            'date_to' => $this->integer(),
            'reserve_id' => $this->integer(),
            'status' => $this->integer(),
            'invoice_id' => $this->integer(),
        ]);
        $this->addForeignKey('reserve_for_child', 'reserve_child', 'reserve_id', 'reserve', 'id', 'CASCADE');
        $this->addForeignKey('invoice_for_child', 'reserve_child', 'invoice_id', 'invoice', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('reserve_for_child', 'reserve_child');
        $this->dropForeignKey('invoice_for_child', 'reserve_child');
        $this->dropTable('reserve_child');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171107_111939_reserve_child_table cannot be reverted.\n";

        return false;
    }
    */
}
