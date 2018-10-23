<?php

use yii\db\Migration;

/**
 * Class m171215_091221_car_info
 */
class m171215_091221_car_info extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('car', 'registration_certificate', $this->string());
        $this->addColumn('car', 'year_of_issue', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('car', 'registration_certificate');
        $this->dropColumn('car', 'year_of_issue');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171215_091221_car_info cannot be reverted.\n";

        return false;
    }
    */
}
