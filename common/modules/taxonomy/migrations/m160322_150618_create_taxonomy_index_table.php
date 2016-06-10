<?php
use yii\db\Schema;
use yii\db\Migration;

class m160322_150618_create_taxonomy_index_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%taxonomy_index}}', [
            'id' => Schema::TYPE_PK,
            'tid' => Schema::TYPE_INTEGER . ' NOT NULL',
            'entity_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'field' => Schema::TYPE_STRING . '(50) NOT NULL',
            'model' => Schema::TYPE_STRING . '(50) NOT NULL'
        ], $tableOptions);  
        
        //$this->createIndex('taxonomy_unique_tid', '{{%user}}', 'tid', false);
        
    }

    public function down()
    {
        $this->dropTable('taxonomy_index');
    }
}
