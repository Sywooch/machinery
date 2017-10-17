<?php

use yii\db\Migration;

class m171012_163026_create_table_communion extends Migration
{
    public function up()
    {

        $this->createTable('communion', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(255)->notNull(),
            'status' => $this->boolean(),
            'create_at' => $this->timestamp(),
            'closed_at' => $this->timestamp(),
            'user_id' => $this->integer(11),
            'user_to' => $this->integer(11),
        ]);
    }

    public function down()
    {
        $this->dropTable('communion');
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
