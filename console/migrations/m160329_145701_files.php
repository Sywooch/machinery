<?php

use yii\db\Schema;
use yii\db\Migration;

class m160329_145701_files extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%files}}', [
            'id' => Schema::TYPE_BIGPK,
            'entity_id' => Schema::TYPE_BIGINT . ' NOT NULL',
            'field' => Schema::TYPE_STRING . '(50) NOT NULL',
            'model' => Schema::TYPE_STRING . '(50) NOT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'path' => Schema::TYPE_STRING . '(255) NOT NULL',
            'size' => Schema::TYPE_BIGINT . ' UNSIGNED NULL DEFAULT NULL',
            'mimetype' => Schema::TYPE_STRING . '(30) NULL DEFAULT NULL',
            'delta' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT "0"'
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
