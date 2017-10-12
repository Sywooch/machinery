<?php

use yii\db\Migration;

class m171012_164149_update_table_currency extends Migration
{
    public function up()
    {
        $this->addColumn('currency','weigth','integer');
    }

    public function down()
    {
        $this->dropColumn('currency','weigth');
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
