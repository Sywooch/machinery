<?php

use yii\db\Migration;
use tigrov\pgsql\Schema;

/**
 * Handles the creation of table `menu`.
 */
class m170102_165847_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%menu}}', [
            'id' => Schema::TYPE_PK,
            'tree' => Schema::TYPE_INTEGER,
            'lft' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'url' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%menu}}');
    }
}
