<?php
use yii\db\Schema;
use yii\db\Migration;

class m160323_195647_sources extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
         $this->createTable('{{%sources}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(100) NOT NULL',  
        ], $tableOptions);
         
        
    }

    public function down()
    {
       $this->dropTable('{{%sources}}');
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
