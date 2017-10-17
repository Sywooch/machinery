<?php

//namespace common\modules\file\migrations;

use yii\db\Schema;
use yii\db\Migration;

class m160329_145701_files extends Migration
{
    public function up()
    {
        $tableOptions = null;

        $this->createTable('{{%files}}', [
            'id' => $this->primaryKey(),
            'entity_id' => $this->bigInteger()->notNull(),
            'field' => $this->string(50)->notNull(),
            'model' => $this->string(50)->notNull(),
            'name' => $this->string(255)->notNull(),
            'path' => $this->string(255)->notNull(),
            'size' => $this->bigInteger()->null(),
            'mimetype' => $this->string(50)->notNull(),
            'storage' => $this->string(255)->null(),
            'delta' => $this->integer()->notNull()->defaultValue(0)
        ], $tableOptions);

        $this->createIndex('entity_id', '{{%files}}', 'entity_id', false);
    }

    public function down()
    {
        $this->dropTable('{{%files}}');
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
