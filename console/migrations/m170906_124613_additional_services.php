<?php

use yii\db\Migration;

class m170906_124613_additional_services extends Migration
{
    public function safeUp()
    {
        $this->createTable('additional_service_type', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);
        $this->db->createCommand()->batchInsert('additional_service_type', ['title'], [['Доставка'], ['Мойка'], ['Доп. оборудование']])->execute();
        $this->createTable('additional_service', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'price' => $this->float(),
            'type_id' => $this->integer(),
        ]);
        $this->addForeignKey('type_for_additional_service', 'additional_service', 'type_id', 'additional_service_type', 'id', 'SET NULL');
        $this->db->createCommand()->batchInsert('additional_service', ['title', 'price', 'type_id'], [
            ['Аэропорт г. Сургут', 500, 1],
            ['ЖД Вокзал', 500, 1],
            ['Город', 500, 1],
            ['г. Нефтеюганск', 500, 1],
            ['г. Ханты-Мансийск', 500, 1],
            ['г. Нижневартовск', 500, 1],
            ['г. Ноябрьск', 500, 1],
            ['г. Новый Уренгой', 500, 1],
            ['Мойка', 500, 2],
            ['Видеорегистратор', 500, 3],
            ['Навигатор', 500, 3],
            ['Детское кресло', 500, 3],
        ])->execute();
    }

    public function safeDown()
    {
        $this->dropForeignKey('type_for_additional_service', 'additional_service');
        $this->dropTable('additional_service');
        $this->dropTable('additional_service_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170906_124613_additional_services cannot be reverted.\n";

        return false;
    }
    */
}
