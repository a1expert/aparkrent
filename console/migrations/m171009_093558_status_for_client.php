<?php

use yii\db\Migration;

class m171009_093558_status_for_client extends Migration
{
    public function safeUp()
    {
        $this->addColumn('client', 'status', $this->integer());
        $this->db->createCommand('UPDATE client SET status = 0')->execute();
    }

    public function safeDown()
    {
        $this->dropColumn('client', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171009_093558_status_for_client cannot be reverted.\n";

        return false;
    }
    */
}
