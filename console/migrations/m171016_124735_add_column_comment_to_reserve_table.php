<?php

use yii\db\Migration;

class m171016_124735_add_column_comment_to_reserve_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve', 'comment', $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn('reserve', 'comment');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171016_124735_add_column_comment_to_reserve_table cannot be reverted.\n";

        return false;
    }
    */
}
