<?php

use yii\db\Migration;

/**
 * Class m171216_152908_name_for_signature
 */
class m171216_152908_name_for_signature extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('client', 'director_name');
        $this->addColumn('client', 'name_for_signature', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('client', 'name_for_signature');
        $this->addColumn('client', 'director_name', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171216_152908_name_for_signature cannot be reverted.\n";

        return false;
    }
    */
}
