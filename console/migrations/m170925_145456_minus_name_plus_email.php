<?php

use yii\db\Migration;

class m170925_145456_minus_name_plus_email extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('reserve', 'surname');
        $this->addColumn('reserve', 'email', $this->string());
    }

    public function safeDown()
    {
        $this->addColumn('reserve', 'surname', $this->string());
        $this->dropColumn('reserve', 'email');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170925_145456_minus_name_plus_email cannot be reverted.\n";

        return false;
    }
    */
}
