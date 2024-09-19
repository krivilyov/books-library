<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribers}}`.
 */
class m240919_134901_create_subscribers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribers}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(),
            'author_id' => $this->integer(),
            'isDone' => $this->integer()->defaultValue(0)
        ]);

        $this->createIndex(
            'idx-subscribe-author_id',
            'subscribers',
            'author_id'
        );

        $this->addForeignKey(
            'fk-subscribe-author_id',
            'subscribers',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscribers}}');
    }
}
