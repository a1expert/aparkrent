<?php

use yii\db\Migration;

class m171002_090912_add_field_to_client extends Migration
{
    public function safeUp()
    {
        $this->addColumn('client', 'drive_license_issue_date', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('client', 'drive_license_issue_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171002_090912_add_field_to_client cannot be reverted.\n";

        return false;
    }
    */
}
