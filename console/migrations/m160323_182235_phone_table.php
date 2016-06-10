<?php

use yii\db\Schema;
use yii\db\Migration;

class m160323_182235_phone_table extends Migration
{
    const TABLE = 'product_phone';
    
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
         $this->createTable('{{%'.self::TABLE.'}}', [
            'id' => Schema::TYPE_BIGPK,
            'group_id' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'source_id' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'sku' => Schema::TYPE_STRING . '(30) NOT NULL',  
            'available' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'price' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0', 
            'rating' => Schema::TYPE_FLOAT . ' UNSIGNED NULL DEFAULT 0', 
            'publish' => Schema::TYPE_SMALLINT . ' NULL DEFAULT NULL',
            'created' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'updated' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'short' => Schema::TYPE_STRING . '(255) NOT NULL DEFAULT ""',
            'description' => Schema::TYPE_TEXT . ' NULL DEFAULT ""',
            'data' => Schema::TYPE_TEXT . ' NULL DEFAULT ""',
        ], $tableOptions);  
        
        $this->createIndex('sku_unique', '{{%'.self::TABLE.'}}', 'sku', true); 
        $this->addForeignKey('fk_source', '{{%'.self::TABLE.'}}', 'source_id', '{{%sources}}', 'id', 'RESTRICT', 'RESTRICT'); 

        $this->createTable('{{%'.self::TABLE.'_index}}', [
            'term_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'entity_id' => Schema::TYPE_BIGINT . ' NOT NULL',
        ], $tableOptions); 
        
        $this->createIndex('term_entity_unique', '{{%'.self::TABLE.'_index}}', 'term_id, entity_id', true);
        $this->addForeignKey('fk_product', '{{%'.self::TABLE.'_index}}', 'entity_id', '{{%'.self::TABLE.'}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_term', '{{%'.self::TABLE.'_index}}', 'term_id', '{{%taxonomy_items}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%'.self::TABLE.'}}');
        $this->dropTable('{{%'.self::TABLE.'_index}}');
    }

}
