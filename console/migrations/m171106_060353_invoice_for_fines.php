<?php

use yii\db\Migration;

class m171106_060353_invoice_for_fines extends Migration
{
    public function safeUp()
    {
        $this->addColumn('fine', 'invoice_id', $this->integer());
        $this->addForeignKey('invoice_for_fine', 'fine', 'invoice_id', 'invoice', 'id', 'set null');
        $fines = $this->db->createCommand('SELECT * FROM fine')->queryAll();
        foreach ($fines as $fine) {
            $this->db->createCommand()->insert('invoice', ['price' => $fine['amount']])->execute();
            $this->db->createCommand()->update('fine', ['invoice_id' => $this->db->lastInsertID], ['id' => $fine['id']])->execute();
        }
        $this->dropColumn('fine', 'amount');
    }

    public function safeDown()
    {
        echo "m171106_060353_invoice_for_fines cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171106_060353_invoice_for_fines cannot be reverted.\n";

        return false;
    }
    */
}
