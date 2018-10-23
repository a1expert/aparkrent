<?php

use yii\db\Migration;

class m170930_081634_client_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('client', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'phone' => $this->string()->unique(),
            'surname' => $this->string(),
            'name' => $this->string(),
            'email' => $this->string(),
            'patronymic' => $this->string(),
            'birthday' => $this->integer(),
            'passport_series' => $this->string(),
            'passport_number' => $this->string(),
            'passport_date_issue' => $this->integer(),
            'passport_place_issue' => $this->text(),
            'registration_place' => $this->text(),
            'residence_place' => $this->text(),
            'additional_phone' => $this->string(),
            'relative_phone' => $this->string(),
            'drive_license_series' => $this->string(),
            'drive_license_number' => $this->string(),
            'company_name' => $this->string(),
            'inn' => $this->string(),
            'kpp' => $this->string(),
            'ogrn' => $this->string(),
            'company_residence' => $this->string(),
            'post_in_company' => $this->string(),
            'fio_for_paper' => $this->string(),
            'account_number' => $this->string(),
            'bik' => $this->string(),
            'bank' => $this->string(),
            'correspondent_account' => $this->string(),
            'company_phone' => $this->string(),
            'company_email' => $this->string(),
        ]);
        $reserves = $this->db->createCommand('SELECT * FROM reserve')->queryAll();
        foreach ($reserves as $reserve) {
            $this->db->createCommand()->insert('client', [
                'type' => 1,
                'name' => $reserve['name'],
                'phone' => $reserve['phone'],
                'email' => $reserve['email'],
            ])->execute();
        }
        $this->dropColumn('reserve', 'legal_type');
        $this->dropColumn('reserve', 'name');
        $this->dropColumn('reserve', 'phone');
        $this->dropColumn('reserve', 'email');
        $this->addColumn('reserve', 'client_id', $this->integer());
        $this->addForeignKey('client_for_reserve', 'reserve', 'client_id', 'client', 'id');
    }

    public function safeDown()
    {
        $this->addColumn('reserve', 'legal_type', $this->integer());
        $this->addColumn('reserve', 'name', $this->string());
        $this->addColumn('reserve', 'phone', $this->string());
        $this->addColumn('reserve', 'email', $this->string());
        $this->dropForeignKey('client_for_reserve', 'reserve');
        $this->dropColumn('reserve', 'client_id ');
        $this->dropTable('client');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170930_081634_client_table cannot be reverted.\n";

        return false;
    }
    */
}
