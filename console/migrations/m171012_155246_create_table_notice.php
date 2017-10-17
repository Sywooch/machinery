<?php

use yii\db\Migration;

class m171012_155246_create_table_notice extends Migration
{
    public function up()
    {
        $this->createTable('notice', [
                'id' => $this->primaryKey(),
                'subject' => $this->string(255)->notNull(),
                'body' => $this->text(),
                'status' => $this->boolean(),
                'create_at' => $this->timestamp(),
                'ready' => $this->timestamp(),
                'user_id' => $this->integer(11)
            ]
        );

    }

    public function down()
    {
        $this->dropTable('notice');
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
