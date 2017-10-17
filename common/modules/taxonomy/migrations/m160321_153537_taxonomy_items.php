<?php

use yii\db\Schema;
use yii\db\Migration;

class m160321_153537_taxonomy_items extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        $this->createTable('{{%taxonomy_items}}', [
            'id' => $this->primaryKey(),
            'vid' => $this->integer()->notNull(),
            'pid' => $this->integer()->null(),
            'name' => $this->string(255)->notNull(),
            'transliteration' => $this->string(255)->notNull(),
            'data' => $this->text()->null(),
            'weight' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex(
            'taxonomy_items_vid_idx',
            'taxonomy_items',
            'vid'
        );

        $this->createIndex(
            'taxonomy_items_transliteration_idx',
            'taxonomy_items',
            'transliteration'
        );

        $this->createIndex(
            'taxonomy_items_name_idx',
            'taxonomy_items',
            'name'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%taxonomy_items}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
