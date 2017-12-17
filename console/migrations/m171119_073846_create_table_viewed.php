<?php

use yii\db\Migration;

class m171119_073846_create_table_viewed extends Migration
{
    public function up()
    {
        $this->createTable('viewed', [
            'id' => $this->primaryKey(),
            'advert_id' => $this->integer(11),
            'user_id' => $this->integer(11),
            'create_at' => $this->timestamp(),
            'user_ip' => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('viewed');
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
