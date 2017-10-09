<?php

use yii\db\Migration;

/**
 * Handles the creation of table `advert_package`.
 */
class m170818_154528_create_advert_package_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('advert_package', [
            'id' => $this->primaryKey(),
            'advert_id' => $this->integer(11),
            'package_id' => $this->integer(11),
        ]);

        $this->addForeignKey(
            'FK_ap_advert', 'advert_package', 'advert_id', 'advert', 'id', 'SET NULL', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_ap_package', 'advert_package', 'package_id', 'order_package', 'id', 'SET NULL', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('advert_package');
    }
}
