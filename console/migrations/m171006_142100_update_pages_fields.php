<?php

use yii\db\Migration;

class m171006_142100_update_pages_fields extends Migration
{
    public function up()
    {
        $this->addColumn('pages','lang','character varying(5)');
        $this->addColumn('pages','parent','integer');
    }

    public function down()
    {
        $this->dropColumn('pages','lang');
        $this->dropColumn('pages','parent');
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
