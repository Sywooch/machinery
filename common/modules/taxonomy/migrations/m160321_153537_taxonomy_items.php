<?php

use yii\db\Schema;
use yii\db\Migration;

class m160321_153537_taxonomy_items extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%taxonomy_items}}', [
            'id' => Schema::TYPE_PK,
            'vid' => Schema::TYPE_INTEGER . ' NOT NULL',
            'pid' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'weight' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0'
        ], $tableOptions);
    }

    public function down()
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
