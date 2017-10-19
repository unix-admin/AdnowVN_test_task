<?php

use yii\db\Migration;

class m171019_134958_add_authors_data extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('authors',['firstname','lastname'],
            [
                ['Тест1', 'Тестович1'],
                ['Тест2', 'Тестович2'],
                ['Тест3', 'Тестович3'],
                ['Тест4', 'Тестович4'],
                ['Тест5', 'Тестович5'],
                ['Тест6', 'Тестович6'],
                ['Тест7', 'Тестович7'],
                ['Тест8', 'Тестович8'],
                ['Тест9', 'Тестович9'],
                ['Тест10', 'Тестович10'],
                ['Тест11', 'Тестович11'],
            ]
            );
    }

    public function safeDown()
    {
        echo "m171019_134958_add_authors_data going down.\n";
        $this->truncateTable('authors');
        return true;
    }

}
