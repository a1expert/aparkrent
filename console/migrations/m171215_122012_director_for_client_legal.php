<?php

use yii\db\Migration;

/**
 * Class m171215_122012_director_for_client_legal
 */
class m171215_122012_director_for_client_legal extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('client', 'director_name', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('client', 'director_name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171215_122012_director_for_client_legal cannot be reverted.\n";

        return false;
    }
    */
}
