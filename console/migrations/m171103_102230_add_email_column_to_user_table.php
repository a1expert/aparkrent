<?php

use yii\db\Migration;

/**
 * Handles adding email to table `user`.
 */
class m171103_102230_add_email_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'email', $this->string()->unique());
        $clients = $this->db->createCommand('SELECT * FROM client')->queryAll();
        foreach ($clients as $client) {
            if ($client['email'] != '') {
                $this->db->createCommand()->update('user', ['email' => $client['email']], ['phone' => $client['phone']])->execute();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'email');
    }
}
