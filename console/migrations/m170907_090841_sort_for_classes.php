<?php

use yii\db\Migration;

class m170907_090841_sort_for_classes extends Migration
{
    public function safeUp()
    {
        $this->addColumn('auto_class', 'sort', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('auto_class', 'sort');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170907_090841_sort_for_classes cannot be reverted.\n";

        return false;
    }
    */
}
