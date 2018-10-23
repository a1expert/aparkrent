<?php

use yii\db\Migration;

class m170922_092629_status_for_reserve extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve', 'status', $this->integer());
        $this->db->createCommand('UPDATE `reserve` SET `status`=' . \frontend\models\Reserve::STATUS_NEW)->execute();
    }

    public function safeDown()
    {
        $this->dropColumn('reserve', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170922_092629_status_for_reserve cannot be reverted.\n";

        return false;
    }
    */
}
