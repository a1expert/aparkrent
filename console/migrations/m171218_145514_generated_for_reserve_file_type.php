<?php

use yii\db\Migration;

/**
 * Class m171218_145514_generated_for_reserve_file_type
 */
class m171218_145514_generated_for_reserve_file_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('reserve_file_type', 'generate_type', $this->string());
        $this->addColumn('reserve_file_type', 'to_client', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('reserve_file_type', 'generate_type');
        $this->dropColumn('reserve_file_type', 'to_client');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171218_145514_generated_for_reserve_file_type cannot be reverted.\n";

        return false;
    }
    */
}
