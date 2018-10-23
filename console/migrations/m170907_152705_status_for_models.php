<?php

use yii\db\Migration;

class m170907_152705_status_for_models extends Migration
{
    public function safeUp()
    {
        $this->addColumn('auto_model', 'status', $this->integer());
        $models = $this->db->createCommand("SELECT * FROM auto_model")->queryAll();
        foreach ($models as $model) {
            $this->db->createCommand()->update('auto_model', ['status' => 1], ['id' => $model['id']])->execute();
        }
    }

    public function safeDown()
    {
        $this->dropColumn('auto_model', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170907_152705_status_for_models cannot be reverted.\n";

        return false;
    }
    */
}
