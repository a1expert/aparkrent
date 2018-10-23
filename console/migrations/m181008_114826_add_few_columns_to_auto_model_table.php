<?php

use yii\db\Migration;

/**
 * Handles adding few to table `auto_model`.
 */
class m181008_114826_add_few_columns_to_auto_model_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->addColumn('auto_model', 'transmission', $this->integer());
        $this->addColumn('auto_model', 'climate_control', $this->integer());
        $this->addColumn('auto_model', 'heating', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function SafeDown()
    {
        $this->dropColumn('auto_model', 'heating');
        $this->dropColumn('auto_model', 'climate_control');
        $this->dropColumn('auto_model', 'transmission');
    }
}
