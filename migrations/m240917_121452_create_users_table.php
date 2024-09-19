<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240917_121452_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(),
        ]);

        $this->insert('{{%users}}', [
            'id' => 15,
            'email' => 'XEGO@yandex.ru',
            'password' => '$2y$13$AWhM2X0xZov91CXSOHpfmOh6T5Ek6vBrfmqgN8UwgttTcs2khK3H2',
            'auth_key' => 'MHeRxRQWoGXdvMUQK8i-JSvEerhoSF2G',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
