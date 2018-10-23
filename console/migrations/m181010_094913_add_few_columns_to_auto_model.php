<?php

use yii\db\Migration;

/**
 * Class m181010_094913_add_few_columns_to_auto_model
 */
class m181010_094913_add_few_columns_to_auto_model extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('auto_model', 'count_free', $this->integer());
        $this->addColumn('auto_model', 'count_total', $this->integer());
        $this->addColumn('auto_model', 'code', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('auto_model', 'code');
        $this->dropColumn('auto_model', 'count_total');
        $this->dropColumn('auto_model', 'count_free');

    }
}
