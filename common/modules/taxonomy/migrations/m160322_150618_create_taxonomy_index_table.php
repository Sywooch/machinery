<?php
use yii\db\Schema;
use yii\db\Migration;

class m160322_150618_create_taxonomy_index_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        $this->createTable('{{%taxonomy_index}}', [
            'id' => $this->primaryKey(),
            'tid' => $this->integer()->notNull(),
            'entity_id' => $this->integer()->notNull(),
            'field' => $this->string(50)->notNull(),
            'model' => $this->string(50)->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'taxonomy_index_tid_idx',
            'taxonomy_index',
            'tid'
        );
        
    }

    public function down()
    {
        $this->dropTable('taxonomy_index');
    }
}
