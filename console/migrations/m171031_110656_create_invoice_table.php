<?php

use yii\db\Migration;

/**
 * Handles the creation of table `invoice`.
 */
class m171031_110656_create_invoice_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('invoice', [
            'id' => $this->primaryKey(),
            'price' => $this->double(),
            'paid_at' => $this->integer(),
            'sberbank_id' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('invoice');
    }
}
