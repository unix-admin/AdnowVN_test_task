<?php

use yii\db\Migration;

class m171019_070932_add_books_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('books',[
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->notNull(),
                'date_create'=> $this->date(),
                'date_update'=> $this->date(),
                'preview' => $this->string(255)->null(),
                'date' => $this->date(),
                'author_id' => $this->integer(),
            ]);
        $this->addForeignKey('FK_authors_relation',
            'books',
            'author_id',
            'authors',
            'id');

    }

    public function safeDown()
    {
        echo "m171019_070932_add_books_table cannot be reverted.\n";
        $this->dropForeignKey('FK_authors_relation','books');
        $this->dropTable('books');
        return true;
    }


}
