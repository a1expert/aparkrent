<?php

use yii\db\Migration;

class m170905_083236_tariff_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('tariff', [
            'id' => $this->primaryKey(),
            'time' => $this->string(),
            'price_for_day' => $this->float(),
            'model_id' => $this->integer(),
        ]);
        $this->addForeignKey('model_for_tariff', 'tariff', 'model_id', 'auto_model', 'id');
        $this->db->createCommand()->batchInsert('tariff', ['time', 'price_for_day', 'model_id'], [
            ['1-3 дня', 1900, 1],
            ['3-5 дня', 1700, 1],
            ['5-7 дня', 1500, 1],
            ['7-14 дня', 1400, 1],
            ['более 2 недель', 1200, 1],
            ['1-3 дня', 1900, 2],
            ['3-5 дня', 1700, 2],
            ['5-7 дня', 1500, 2],
            ['7-14 дня', 1400, 2],
            ['более 2 недель', 1200, 2],
        ])->execute();
    }

    public function safeDown()
    {
        $this->dropForeignKey('model_for_tariff', 'tariff');
        $this->dropTable('tariff');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170905_083236_tariff_table cannot be reverted.\n";

        return false;
    }
    */
}
