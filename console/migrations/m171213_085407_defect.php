<?php

use yii\db\Migration;

/**
 * Class m171213_085407_defect
 */
class m171213_085407_defect extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('defect_place', [
            'id' => $this->primaryKey(),
            'code' => $this->integer()->unique(),
            'title' => $this->string(),
        ]);
        $this->batchInsert('defect_place', ['code', 'title'], [
            [1, 'Передний бампер, левая сторона'],
            [2, 'Передний дополнительный спойлер'],
            [3, 'Переднее крыло, левая сторона'],
            [4, 'Арка переднего колеса, левая сторона'],
            [5, 'Переднее колесо или колпак переднего колеса, левая сторона'],
            [6, 'Шина переднего колеса, левая сторона'],
            [7, 'Наружнее зеркало, левая сторона'],
            [9, 'Передняя дверь, левая сторона'],
            [10, 'Порог передней двери, левая сторона'],
            [11, 'Задняя дверь, левая сторона (и центральная стойка, только для четырехдверных моделей)'],
            [12, 'Порог задней двери, левая сторона'],
            [13, 'Арка заднего колеса, левая сторона'],
            [14, 'Заднее колесо или колпак заднего колеса'],
            [15, 'Шина заднего колеса, левая сторона'],
            [16, 'Задняя панель левая сторона'],
            [17, 'Задний бампер левая сторона'],
            [18, 'Задний дополнительный спойлер левая сторона'],
            [19, 'Задний дополнительный спойлер'],
            [20, 'Задний бампер'],
            [21, 'Панель задка'],
            [22, 'Блок задних фонарей, левая сторона'],
            [23, 'Блок задних фонарей, правая сторона'],
            [24, 'Задняя дверь/крышка багажника'],
            [25, 'Заднее стекло'],
            [26, 'Задний дополнительный спойлер, правая сторона'],
            [27, 'Задний бампер, правая сторона'],
            [28, 'Задняя панель, правая сторона'],
            [29, 'Крышка топливного бака и окантовка'],
            [30, 'Арка заднего колеса, правая сторона'],
            [31, 'Заднее колесо или колпак заднего колеса, правая сторона'],
            [32, 'Шина заднего колеса, правая сторона'],
            [33, 'Задняя дверь, правая сторона'],
            [34, 'Порог задней двери, правая сторона'],
            [35, 'Передняя дверь, правая сторона'],
            [36, 'Порог передней двери, правая сторона'],
            [37, 'Наружное зеркало, правая сторона'],
            [38, 'Арка переднего колеса, правая сторона'],
            [39, 'Переднее крыло, правая сторона'],
            [40, 'переднее колесо или колпак переднего колеса, правая сторона'],
            [41, 'Шина переднего колеса, правая сторона'],
            [42, 'Передний бампер, правая сторона'],
            [43, 'Передний дополнительный спойлер, правая сторона'],
            [44, 'Передний дополнительный спойлер'],
            [45, 'Передний бампер'],
            [46, 'Фары и указатели поворота, правая сторона'],
            [47, 'Фары и указатели поворота, левая сторона'],
            [49, 'Решетка радиатора'],
            [50, 'Капот'],
            [51, 'Лобовая панель'],
            [52, 'Стеклоочистители'],
            [53, 'Ветровое стекло и передние стойки'],
            [54, 'Крыша (люк, если есть)'],
            [55, 'Прочее'],
        ]);
        $this->createTable('defect_size', [
            'id' => $this->primaryKey(),
            'code' => $this->integer()->unique(),
            'title' => $this->string(),
        ]);
        $this->batchInsert('defect_size', ['code', 'title'], [
            [1, '=<3 см'],
            [2, '=3-10 см'],
            [3, '=10-20 см'],
            [4, '=20-30 см'],
            [5, '=>30 см'],
            [6, '= серьезно поврежден, утерян'],
        ]);
        $this->createTable('defect_degree', [
            'id' => $this->primaryKey(),
            'code' => $this->integer()->unique(),
            'title' => $this->string(),
        ]);
        $this->batchInsert('defect_degree', ['code', 'title'], [
            [1, 'Незначительные дефекты'],
            [2, 'Царапины и вмятины'],
            [3, 'Замена детали'],
            [4, 'Несоответствие стандарту'],
            [5, 'Списание'],
        ]);
        $this->createTable('defect_damage', [
            'id' => $this->primaryKey(),
            'code' => $this->integer()->unique(),
            'title' => $this->string(),
        ]);
        $this->batchInsert('defect_damage', ['code', 'title'], [
            [1, 'Царапина'],
            [2, 'Скол'],
            [3, 'Сломан'],
            [4, 'Вмятина'],
            [5, 'Повреждение стекла'],
            [6, 'Отсутствует'],
            [7, 'Прожжено'],
        ]);
        $this->createTable('defect', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer(),
            'place_id' => $this->integer(),
            'size_id' => $this->integer(),
            'degree_id' => $this->integer(),
            'damage_id' => $this->integer(),
        ]);
        $this->addForeignKey('car_for_defect', 'defect', 'car_id', 'car', 'id', 'CASCADE');
        $this->addForeignKey('place_for_defect', 'defect', 'place_id', 'defect_place', 'id');
        $this->addForeignKey('size_for_defect', 'defect', 'size_id', 'defect_size', 'id');
        $this->addForeignKey('degree_for_defect', 'defect', 'degree_id', 'defect_degree', 'id');
        $this->addForeignKey('damage_for_defect', 'defect', 'damage_id', 'defect_damage', 'id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('car_for_defect', 'defect');
        $this->dropForeignKey('place_for_defect', 'defect');
        $this->dropForeignKey('size_for_defect', 'defect');
        $this->dropForeignKey('degree_for_defect', 'defect');
        $this->dropForeignKey('damage_for_defect', 'defect');

        $this->dropTable('defect_place');
        $this->dropTable('defect_size');
        $this->dropTable('defect_degree');
        $this->dropTable('defect_damage');
        $this->dropTable('defect');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171213_085407_defect cannot be reverted.\n";

        return false;
    }
    */
}
