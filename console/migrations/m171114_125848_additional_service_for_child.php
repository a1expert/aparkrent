<?php

use yii\db\Migration;

/**
 * Class m171114_125848_additional_service_for_child
 */
class m171114_125848_additional_service_for_child extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('reserve_child', 'service_id', $this->integer());
        $this->addForeignKey('service_for_child', 'reserve_child', 'service_id', 'additional_service', 'id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('service_for_child', 'reserve_child');
        $this->dropColumn('reserve_child', 'service_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171114_125848_additional_service_for_child cannot be reverted.\n";

        return false;
    }
    */
}
