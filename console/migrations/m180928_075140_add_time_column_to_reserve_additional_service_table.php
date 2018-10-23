<?php

use yii\db\Migration;

/**
 * Handles adding time to table `reserve_additional_service`.
 */
class m180928_075140_add_time_column_to_reserve_additional_service_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->addColumn('reserve_additional_service', 'time', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function SafeDown()
    {
        $this->dropColumn('reserve_additional_service', 'time');
    }
}
