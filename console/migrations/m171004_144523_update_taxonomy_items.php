<?php

use yii\db\Migration;

class m171004_144523_update_taxonomy_items extends Migration
{
    public function up()
    {
        $this->addColumn('taxonomy_items','icon_name','string NULL');
    }

    public function down()
    {
        $this->dropColumn('taxonomy_items','icon_name');
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
