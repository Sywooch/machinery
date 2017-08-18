<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_package`.
 */
class m170818_154344_create_user_package_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_package', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'date_at' => $this->timestamp(), // дата активации
            'package_id' => $this->integer(11),
            'deadline' => $this->timestamp(), // дата окончания действия
        ]);
        $this->addForeignKey(
            'FK_up_user', 'user_package', 'user_id', 'user', 'id', 'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_up_package', 'user_package', 'package_id', 'tarif_packages', 'id', 'SET NULL', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_package');
    }
}
