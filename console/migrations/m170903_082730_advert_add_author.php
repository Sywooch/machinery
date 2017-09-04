<?php

use yii\db\Migration;

class m170903_082730_advert_add_author extends Migration
{
    public function up()
    {
        $this->addColumn('advert','user_id','integer');

    }

    public function down()
    {
        $this->dropColumn('advert','user_id');
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
