<?php

use yii\db\Migration;

class m170901_073838_advert_update extends Migration
{
    public function up()
    {
        $this->addColumn('advert','meta_description','string NULL');
    }

    public function down()
    {
        $this->dropColumn('advert','meta_description');
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
