<?php

use yii\db\Migration;

class m170906_092524_change_keys extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('model_for_tariff', 'tariff');
        $this->addForeignKey('model_for_tariff', 'tariff', 'model_id', 'auto_model', 'id', 'SET NULL');

        $this->dropForeignKey('mark_for_model', 'auto_model');
        $this->addForeignKey('mark_for_model', 'auto_model', 'mark_id', 'auto_mark', 'id', 'SET NULL');

        $this->dropForeignKey('class_for_model', 'auto_model');
        $this->addForeignKey('class_for_model', 'auto_model', 'class_id', 'auto_class', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('model_for_tariff', 'tariff');
        $this->addForeignKey('model_for_tariff', 'tariff', 'model_id', 'auto_model', 'id');

        $this->dropForeignKey('mark_for_model', 'auto_model');
        $this->addForeignKey('mark_for_model', 'auto_model', 'mark_id', 'auto_mark', 'id');

        $this->dropForeignKey('class_for_model', 'auto_model');
        $this->addForeignKey('class_for_model', 'auto_model', 'class_id', 'auto_class', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170906_092524_change_keys cannot be reverted.\n";

        return false;
    }
    */
}
