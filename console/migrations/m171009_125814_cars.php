<?php

use yii\db\Migration;

class m171009_125814_cars extends Migration
{
    public function safeUp()
    {
        $this->createTable('car', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer(),
            'number' => $this->string(),
            'vin' => $this->string(),
        ]);
        $this->addForeignKey('model_for_car', 'car', 'model_id', 'auto_model', 'id');
        $this->addColumn('reserve', 'car_id', $this->integer());
        $this->addForeignKey('car_for_reserve', 'reserve', 'car_id', 'car', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('car_for_reserve', 'reserve');
        $this->dropColumn('reserve', 'car_id');
        $this->dropForeignKey('model_for_car', 'car');
        $this->dropTable('car');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171009_125814_cars cannot be reverted.\n";

        return false;
    }
    */
}
