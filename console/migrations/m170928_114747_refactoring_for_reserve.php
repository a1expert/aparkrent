<?php

use yii\db\Migration;

class m170928_114747_refactoring_for_reserve extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('reserve', 'passport_1');
        $this->dropColumn('reserve', 'passport_2');
        $this->dropColumn('reserve', 'drive_license');
        $this->addColumn('reserve', 'legal_type', $this->integer());
        $this->createTable('reserve_file', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'path' => $this->string(),
            'reserve_id' => $this->integer(),
        ]);
        $this->addForeignKey('reserve_for_file', 'reserve_file', 'reserve_id', 'reserve', 'id');
    }

    public function safeDown()
    {
        $this->addColumn('reserve', 'passport_1', $this->string());
        $this->addColumn('reserve', 'passport_2', $this->string());
        $this->addColumn('reserve', 'drive_license', $this->string());
        $this->dropColumn('reserve', 'legal_type');
        $this->dropTable('reserve_file');
        $this->dropForeignKey('reserve_for_file', 'reserve_file');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170928_114747_refactoring_for_reserve cannot be reverted.\n";

        return false;
    }
    */
}
