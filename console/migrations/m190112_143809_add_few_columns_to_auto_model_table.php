<?php

use yii\db\Migration;

/**
 * Handles adding few to table `auto_model`.
 */
class m190112_143809_add_few_columns_to_auto_model_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('auto_model', 'consumption', $this->string());
        $this->addColumn('auto_model', 'abs', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('auto_model', 'abs');
        $this->dropColumn('auto_model', 'consumption');
    }
}
