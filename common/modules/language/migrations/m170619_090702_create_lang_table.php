<?php

use yii\db\Migration;
use tigrov\pgsql\Schema;

/**
 * Handles the creation of table `lang`.
 */
class m170619_090702_create_lang_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(255)->notNull(),
            'local' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'default' => $this->smallInteger()->null(),
            'date_update' => $this->integer()->notNull(),
            'date_create' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->batchInsert('language', ['url', 'local', 'name', 'default', 'date_update', 'date_create'], [
            ['en', 'en-EN', 'English', 0, time(), time()],
            ['ru', 'ru-RU', 'Русский', 1, time(), time()],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }
}
