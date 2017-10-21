<?php

use yii\db\Migration;

class m171018_144619_update_notice_table extends Migration
{
    public function up()
    {
        $this->addColumn('notice','type','string NULL');
        $this->addColumn('notice','action','string NULL');
    }

    public function down()
    {
        $this->dropColumn('notice','type');
        $this->dropColumn('notice','action');
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
