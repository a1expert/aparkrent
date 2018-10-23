<?php

use yii\db\Migration;

class m170904_101224_auto_mark extends Migration
{
    public function safeUp()
    {
        $this->createTable('auto_mark', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'logo' => $this->string(),
            'color' => $this->string(),
        ]);

        $this->db->createCommand()->batchInsert(
            'auto_mark',
            ['title', 'logo', 'color'],
            [
                ['KIA', '/images/kia.png', '#C21230'],
                ['RENO', '/images/renault.png', '#F9BE00'],
                ['UAZ', '/images/uaz.png', '#00632A'],
                ['RAVON', '/images/ravon.png', '#005598'],
            ]
        )->execute();
    }

    public function safeDown()
    {
        $this->dropTable('auto_mark');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170904_101224_auto_mark cannot be reverted.\n";

        return false;
    }
    */
}
