<?php

use yii\db\Migration;

class m171012_151302_source_for_reserve_and_clients extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve', 'source', $this->integer());
        $this->addColumn('client', 'source', $this->integer());
        $this->db->createCommand()->update('reserve', ['source' => \common\models\Reserve::SOURCE_MANAGER])->execute();
        $this->db->createCommand()->update('client', ['source' => \common\models\Client::SOURCE_MANAGER])->execute();
    }

    public function safeDown()
    {
        $this->dropColumn('reserve', 'source');
        $this->dropColumn('client', 'source');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171012_151302_source_for_reserve_and_clients cannot be reverted.\n";

        return false;
    }
    */
}
