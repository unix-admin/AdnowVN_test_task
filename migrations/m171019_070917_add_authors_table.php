<?php

use yii\db\Migration;

class m171019_070917_add_authors_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('authors',[
            'id' => $this->primaryKey(),
            'firstname' => $this->string(255)->notNull(),
            'lastname' => $this->string(255)->notNull(),
        ]);
    }

    public function safeDown()
    {
        echo "m171019_070917_add_authors_table going down.\n";
        $this->dropTable('authors');
        return true;
    }

}
