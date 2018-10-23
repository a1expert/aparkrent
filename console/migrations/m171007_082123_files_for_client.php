<?php

use yii\db\Migration;

class m171007_082123_files_for_client extends Migration
{
    public function safeUp()
    {
        $this->createTable('client_file', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'path' => $this->string(),
            'name' => $this->string(),
        ]);
        $this->addForeignKey('client_for_file', 'client_file', 'client_id', 'client', 'id');
        $filesToClient = $this->db->createCommand('SELECT * FROM reserve_file WHERE type_id IS NULL')->queryAll();
        foreach ($filesToClient as $file) {
            $reserve = $this->db->createCommand('SELECT * FROM reserve WHERE id='.$file['reserve_id'])->queryOne();
            $client = $this->db->createCommand('SELECT * FROM client WHERE id='.$reserve['client_id'])->queryOne();
            $this->db->createCommand()->insert('client_file', [
                'client_id' => $client['id'],
                'path' => $file['path'],
                'name' => $file['name'],
            ])->execute();
            $this->db->createCommand('DELETE FROM reserve_file WHERE id='.$file['id'])->execute();
        }
    }

    public function safeDown()
    {
        echo 'm171007_082123_files_for_client can\'t be reverted.';
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171007_082123_files_for_client cannot be reverted.\n";

        return false;
    }
    */
}
