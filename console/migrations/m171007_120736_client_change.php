<?php

use yii\db\Migration;

class m171007_120736_client_change extends Migration
{
    public function safeUp()
    {
        $this->createTable('client_change', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'attribute' => $this->string(),
            'old_value' => $this->string(),
            'new_value' => $this->string(),
        ]);
        $this->addForeignKey('client_for_change', 'client_change', 'client_id', 'client', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('client_for_change', 'client_change');
        $this->dropTable('client_change');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171007_120736_client_change cannot be reverted.\n";

        return false;
    }
    */
}
