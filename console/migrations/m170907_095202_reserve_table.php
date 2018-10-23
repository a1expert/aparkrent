<?php

use yii\db\Migration;

class m170907_095202_reserve_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('reserve', [
            'id' => $this->primaryKey(),
            'surname' => $this->string(),
            'name' => $this->string(),
            'phone' => $this->string(),
            'model_id' => $this->integer(),
            'date_from' => $this->integer(),
            'date_to' => $this->integer(),
            'delivery_date' => $this->integer(),
            'passport_1' => $this->string(),
            'passport_2' => $this->string(),
            'drive_license' => $this->string(),
            'price' => $this->float(),
        ]);
        $this->addForeignKey('model_for_reserve', 'reserve', 'model_id', 'auto_model', 'id', 'SET NULL');
        $this->createTable('reserve_additional_service', [
            'id' => $this->primaryKey(),
            'reserve_id' => $this->integer(),
            'additional_service_id' => $this->integer(),
        ]);
        $this->addForeignKey('reserve_for_additional_service', 'reserve_additional_service', 'reserve_id', 'reserve', 'id', 'SET NULL');
        $this->addForeignKey('additional_service_for_reserve', 'reserve_additional_service', 'additional_service_id', 'additional_service', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('additional_service_for_reserve', 'reserve_additional_service');
        $this->dropForeignKey('reserve_for_additional_service', 'reserve_additional_service');
        $this->dropTable('reserve_additional_service');
        $this->dropForeignKey('model_for_reserve', 'reserve');
        $this->dropTable('reserve');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170907_095202_reserve_table cannot be reverted.\n";

        return false;
    }
    */
}
