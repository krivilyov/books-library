<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors_books}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%authors}}`
 * - `{{%books}}`
 */
class m240918_183103_create_junction_table_for_authors_and_books_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%authors_books}}', [
            'author_id' => $this->integer(),
            'book_id' => $this->integer(),
            'PRIMARY KEY(author_id, book_id)',
        ]);

        // creates index for column `authors_id`
        $this->createIndex(
            '{{%idx-authors_books-authors_id}}',
            '{{%authors_books}}',
            'author_id'
        );

        // add foreign key for table `{{%authors}}`
        $this->addForeignKey(
            '{{%fk-authors_books-author_id}}',
            '{{%authors_books}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE'
        );

        // creates index for column `books_id`
        $this->createIndex(
            '{{%idx-authors_books-book_id}}',
            '{{%authors_books}}',
            'book_id'
        );

        // add foreign key for table `{{%books}}`
        $this->addForeignKey(
            '{{%fk-authors_books-book_id}}',
            '{{%authors_books}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );

        $this->batchInsert('{{%authors_books}}', ['author_id', 'book_id'], [
            [4,13],
            [4,14],
            [5,10],
            [5,11],
            [6,15],
            [6,16],
            [6,17],
            [7,12],
            [8,12]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%authors}}`
        $this->dropForeignKey(
            '{{%fk-authors_books-authors_id}}',
            '{{%authors_books}}'
        );

        // drops index for column `authors_id`
        $this->dropIndex(
            '{{%idx-authors_books-authors_id}}',
            '{{%authors_books}}'
        );

        // drops foreign key for table `{{%books}}`
        $this->dropForeignKey(
            '{{%fk-authors_books-books_id}}',
            '{{%authors_books}}'
        );

        // drops index for column `books_id`
        $this->dropIndex(
            '{{%idx-authors_books-books_id}}',
            '{{%authors_books}}'
        );

        $this->dropTable('{{%authors_books}}');
    }
}
