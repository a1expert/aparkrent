<?php

use backend\models\Client;
use yii\db\Migration;

class m171004_114409_type_for_files extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve_file', 'type_id', $this->integer());
        $this->createTable('reserve_file_type', [
            'id' => $this->primaryKey(),
            'legal_type' => $this->integer(),
            'title' => $this->string(),
        ]);
        $this->addForeignKey('type_for_file', 'reserve_file', 'type_id', 'reserve_file_type', 'id', 'SET NULL');

        $this->db->createCommand()->batchInsert('reserve_file_type', ['legal_type', 'title'], [
            [null, 'Договор'],
            [null, 'Акт получения авто'],
            [null, 'Дефектовочная ведомость на момент получения'],
            [null, 'Акт возврата авто'],
            [null, 'Дефектовочная ведомость на момент возврата'],
            [null, 'Дополнительное соглашение'],
            [Client::TYPE_INDIVIDUAL, 'Квитанция'],
            [Client::TYPE_INDIVIDUAL, 'Квитанция по дополнительному соглашению'],
            [Client::TYPE_LEGAL, 'Счет на оплату'],
            [Client::TYPE_LEGAL, 'Акт выполненных работ'],
            [Client::TYPE_LEGAL, 'Акт выполненных работ по дополнительному соглашению'],
            [Client::TYPE_LEGAL, 'Счет на оплату по дополнительному соглашению'],
        ])->execute();
    }

    public function safeDown()
    {
        $this->dropForeignKey('type_for_file', 'reserve_file');
        $this->dropColumn('reserve_file', 'type_id');
        $this->dropTable('reserve_file_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171004_114409_type_for_files cannot be reverted.\n";

        return false;
    }
    */
}
