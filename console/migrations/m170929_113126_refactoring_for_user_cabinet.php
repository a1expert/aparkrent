<?php

use yii\db\Migration;

class m170929_113126_refactoring_for_user_cabinet extends Migration
{
    public function safeUp()
    {
        $this->dropTable('user');
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'phone' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'blocked_at' => $this->integer(),
            'auth_key' => $this->string(32)->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'password_reset_token' => $this->string(),
        ]);
        $this->createTable('crm_user', [
            'id' => $this->primaryKey(),
            'phone' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'blocked_at' => $this->integer(),
            'auth_key' => $this->string(32)->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'password_reset_token' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('user');
        $this->dropTable('crm_user');
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170929_113126_refactoring_for_user_cabinet cannot be reverted.\n";

        return false;
    }
    */
}
