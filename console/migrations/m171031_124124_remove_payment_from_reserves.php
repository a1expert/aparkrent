<?php

use yii\db\Migration;

class m171031_124124_remove_payment_from_reserves extends Migration
{
    public function safeUp()
    {
        $this->addColumn('reserve', 'invoice_id', $this->integer());
        $this->addForeignKey('invoice_for_reserve', 'reserve', 'invoice_id', 'invoice', 'id', 'set null');
        $reserves = $this->db->createCommand('SELECT * FROM reserve')->queryAll();
        foreach ($reserves as $reserve) {
            $this->db->createCommand()->insert('invoice', ['paid_at' => $reserve['paid_at'], 'price' => $reserve['paid_at'], 'sberbank_id' => $reserve['sberbank_id']])->execute();
            $this->db->createCommand()->update('reserve', ['invoice_id' => $this->db->lastInsertID], ['id' => $reserve['id']])->execute();
        }
        $this->dropColumn('reserve', 'price');
        $this->dropColumn('reserve', 'sberbank_id');
        $this->dropColumn('reserve', 'paid_at');
    }

    public function safeDown()
    {
        echo "m171031_124124_remove_payment_from_reserves cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171031_124124_remove_payment_from_reserves cannot be reverted.\n";

        return false;
    }
    */
}
