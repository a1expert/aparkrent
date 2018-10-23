<?php

use yii\db\Migration;

/**
 * Class m171127_152009_bonuses_for_invoices
 */
class m171127_152009_bonuses_for_invoices extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('invoice', 'bonuses', $this->double());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('invoice', 'bonuses');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171127_152009_bonuses_for_invoices cannot be reverted.\n";

        return false;
    }
    */
}
