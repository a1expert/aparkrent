<?php

use yii\db\Migration;

class m171003_153355_conditioner extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('auto_model', 'disk');
        $this->addColumn('auto_model', 'conditioner', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('auto_model', 'conditioner');
        $this->addColumn('auto_model', 'disk', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171003_153355_conditioner cannot be reverted.\n";

        return false;
    }
    */
}
