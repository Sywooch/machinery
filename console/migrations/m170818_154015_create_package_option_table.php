<?php

use yii\db\Migration;

/**
 * Handles the creation of table `package_option`.
 */
class m170818_154015_create_package_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('package_option', [
            'id' => $this->primaryKey(),
            'package_id' => $this->integer(11),
            'option_id' => $this->integer(11),
        ]);

        $this->addForeignKey(
            'FK_pa_package', 'package_option', 'package_id', 'tarif_packages', 'id', 'SET NULL', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_pa_option', 'package_option', 'option_id', 'tarif_options', 'id', 'SET NULL', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('package_option');
    }
}
