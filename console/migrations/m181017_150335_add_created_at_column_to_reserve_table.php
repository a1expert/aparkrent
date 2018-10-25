<?php

use yii\db\Migration;

/**
 * Handles adding created_at to table `reserve`.
 */
class m181017_150335_add_created_at_column_to_reserve_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->addColumn('reserve', 'created_at', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function SafeDown()
    {
        $this->dropColumn('reserve', 'created_at');
    }
}
