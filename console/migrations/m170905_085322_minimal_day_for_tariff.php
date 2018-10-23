<?php

use yii\db\Migration;

class m170905_085322_minimal_day_for_tariff extends Migration
{
    public function safeUp()
    {
        $this->addColumn('tariff', 'minimal_days', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('tariff', 'minimal_days');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170905_085322_minimal_day_for_tariff cannot be reverted.\n";

        return false;
    }
    */
}
