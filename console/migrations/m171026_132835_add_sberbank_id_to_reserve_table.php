<?php

use yii\db\Migration;

class m171026_132835_add_sberbank_id_to_reserve_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve', 'sberbank_id', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('reserve', 'sberbank_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171026_132835_add_sberbank_id_to_reserve_table cannot be reverted.\n";

        return false;
    }
    */
}
