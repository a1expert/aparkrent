<?php

use yii\db\Migration;

/**
 * Class m171206_112943_sort_for_models
 */
class m171206_112943_sort_for_models extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('auto_model', 'sort', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('auto_model', 'sort');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171206_112943_sort_for_models cannot be reverted.\n";

        return false;
    }
    */
}
