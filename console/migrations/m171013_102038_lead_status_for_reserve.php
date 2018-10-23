<?php

use yii\db\Migration;

class m171013_102038_lead_status_for_reserve extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve', 'lead_status', $this->integer());
        $this->db->createCommand()->update('reserve', ['lead_status' => \common\models\Reserve::LEAD_STATUS_OPEN], ['status' => \common\models\Reserve::STATUS_ACCEPTED])->execute();
    }

    public function safeDown()
    {
        $this->dropColumn('reserve', 'lead_status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171013_102038_lead_status_for_reserve cannot be reverted.\n";

        return false;
    }
    */
}
