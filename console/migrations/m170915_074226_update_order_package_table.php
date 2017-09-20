<?php

use yii\db\Migration;

class m170915_074226_update_order_package_table extends Migration
{
    public function up()
    {
        $this->addColumn('order_package','deadline','timestamp');
        $this->addColumn('order_package','date_pay','timestamp');
        $this->addColumn('order_package','advert_id','integer');
        $this->addForeignKey(
            'FK_order_advert', 'order_package', 'advert_id', 'advert', 'id', 'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_order_user', 'order_package', 'user_id', 'user', 'id', 'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_order_package', 'order_package', 'package_id', 'tarif_packages', 'id', 'SET NULL', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropColumn('order_package','deadline');
        $this->dropColumn('order_package','date_pay');
        $this->dropColumn('order_package','advert_id');
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
