<?php

use yii\db\Migration;

class m170910_125817_user_pack_add_order extends Migration
{
    public function up()
    {
        $this->addColumn('user_package','order_id','integer');
    }

    public function down()
    {
        $this->dropColumn('user_package','order_id');
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
