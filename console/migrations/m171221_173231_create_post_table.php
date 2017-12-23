<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m171221_173231_create_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text(),
            'created' => $this->integer(11),
            'updated' => $this->integer(11),
            'published' => $this->integer(11),
            'status' => $this->boolean(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('post');
    }
}
