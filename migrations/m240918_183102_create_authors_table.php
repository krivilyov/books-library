<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m240918_183102_create_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'patronymic' => $this->string(),
        ]);

        $this->batchInsert('{{%authors}}', ['id', 'name', 'surname', 'patronymic'], [
            [3,'Александр','Пушкин','Сергеевич'],
            [4,'Николай','Гоголь','Васильевич'],
            [5,'Лев','Толстой','Николаевич'],
            [6,'Михаил','Лермонтов','Юрьевич'],
            [7,'Дмитрий','Котеров','Владимирович'],
            [8,'Игорь','Симдянов','Викторович']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }
}
