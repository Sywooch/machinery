<?php

use yii\db\Migration;

class m170920_145816_del_option_of_tarif extends Migration
{
    public function up()
    {
        $table = $this->db->schema->getTableSchema('tarif_packages');
        if(!isset($table->columns['options'])) {
            // Column doesn't exist
            $this->addColumn('tarif_packages','options','text NULL');
        }
    }

    public function down()
    {
        $this->dropColumn('tarif_packages','options');
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
