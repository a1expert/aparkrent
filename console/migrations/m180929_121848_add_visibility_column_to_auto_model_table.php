<?php

use yii\db\Migration;

/**
 * Handles adding visibility to table `auto_model`.
 */
class m180929_121848_add_visibility_column_to_auto_model_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->addColumn('auto_model', 'visibility', $this->integer()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function SafeDown()
    {
        $this->dropColumn('auto_model', 'visibility');
    }
}
