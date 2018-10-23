<?php

use yii\db\Migration;

class m171003_134101_fines_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('fine', [
            'id' => $this->primaryKey(),
            'reserve_id' => $this->integer(),
            'date' => $this->integer(),
            'paragraph' => $this->string(),
            'resolution_number' => $this->string(),
            'amount' => $this->float(),
        ]);
        $this->addForeignKey('reserve_for_fine', 'fine', 'reserve_id', 'reserve', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('reserve_for_fine', 'fine');
        $this->dropTable('fine');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171003_134101_fines_table cannot be reverted.\n";

        return false;
    }
    */
}
