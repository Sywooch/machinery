<?php

use yii\db\Migration;

class m171012_163611_create_table_communion_message extends Migration
{
    public function up()
    {
        $this->createTable('communion_message', [
            'id' => $this->primaryKey(),
            'communion_id' => $this->integer(),
            'status' => $this->boolean(),
            'create_at' => $this->timestamp(),
            'ready' => $this->timestamp(),
            'user_id' => $this->integer(11),
            'body' => $this->text()
        ]);
    }

    public function down()
    {
        $this->dropTable('communion_message');
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
