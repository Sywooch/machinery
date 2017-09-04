<?php

use yii\db\Migration;

class m170902_081653_advert_update_counter extends Migration
{
    public function up()
    {
        $this->addColumn('advert','viewed','integer DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('advert','viewed');
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
