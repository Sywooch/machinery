<?php

use yii\db\Schema;
use yii\db\Migration;

class m160321_153520_taxonomy_vocabulary extends Migration
{
    public function up()
    {
        $tableOptions = null;

        $this->createTable('{{%taxonomy_vocabulary}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'prefix' => $this->string(50)->notNull(),
            'transliteration' => $this->string(255)->notNull(),
            'weight' => $this->integer()->notNull()->defaultValue(0)
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%taxonomy_vocabulary}}');
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
