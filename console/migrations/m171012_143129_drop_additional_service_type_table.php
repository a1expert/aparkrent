<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `additional_service_type`.
 */
class m171012_143129_drop_additional_service_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey('type_for_additional_service', 'additional_service');
        $this->dropTable('additional_service_type');
        $this->renameColumn('additional_service', 'type_id', 'type');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('additional_service_type', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);
        $this->renameColumn('additional_service', 'type', 'type_id');
        $this->addForeignKey('type_for_additional_service', 'additional_service', 'type_id', 'additional_service_type', 'id');
    }
}
