<?php

use yii\db\Migration;

class m170904_104811_auto_model extends Migration
{
    public function safeUp()
    {
        $this->createTable('auto_class', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);
        $this->db->createCommand()->batchInsert(
            'auto_class',
            ['title'],
            [
                ['Комфорт класс'],
                ['Эконом класс'],
                ['Премиум класс'],
                ['Бизнес класс'],
            ]
        )->execute();

        $this->createTable('auto_model', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'mark_id' => $this->integer(),
            'image' => $this->string(),
            'equipment' => $this->string(),
            'engine' => $this->string(),
            'disk' => $this->string(),
            'audio' => $this->string(),
            'class_id' => $this->integer(),
        ]);
        $this->addForeignKey('mark_for_model', 'auto_model', 'mark_id', 'auto_mark', 'id');
        $this->addForeignKey('class_for_model', 'auto_model', 'class_id', 'auto_class', 'id');
        $this->db->createCommand()->batchInsert(
            'auto_model',
            ['title', 'description', 'mark_id', 'image', 'equipment', 'engine', 'disk', 'audio', 'class_id'],
            [
                ['RIO', 'Есть много вариантов Lorem Ipsum, но большинство из них имеет не всегда приемлемые модификации, например, юмористические вставки или слова, которые даже отдалённо не напоминают латынь.', 1, '/images/car1.png', 'Comfort Аудио', '1,6 л 123 л.с.', 'R21', '4 динамика, AUX, USB', 1],
                ['LOGAN', 'Есть много вариантов Lorem Ipsum, но большинство из них имеет не всегда приемлемые модификации, например, юмористические вставки или слова, которые даже отдалённо не напоминают латынь.', 2, '/images/car2.png', 'Comfort Аудио', '1,6 л 123 л.с.', 'R21', '4 динамика, AUX, USB', 2],
            ]
        )->execute();
    }

    public function safeDown()
    {
        $this->dropForeignKey('mark_for_model', 'auto_model');
        $this->dropTable('auto_model');
        $this->dropForeignKey('class_for_model', 'auto_model');
        $this->dropTable('auto_class');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170904_104811_auto_model cannot be reverted.\n";

        return false;
    }
    */
}
