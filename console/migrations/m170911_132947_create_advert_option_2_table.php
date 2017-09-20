<?php

use yii\db\Migration;

/**
 * Handles the creation of table `advert_option_2`.
 */
class m170911_132947_create_advert_option_2_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('advert_option_2', [
            'id' => $this->primaryKey(),
            'advert_id' => $this->integer(11),
            'option_id' => $this->integer(11),
            'order_id' => $this->integer(11),
        ]);
        $this->addForeignKey(
            'FK_option_advert_2', 'advert_option_2', 'advert_id', 'advert', 'id', 'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_option_option_2', 'advert_option_2', 'option_id', 'tarif_options', 'id', 'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_option_order_2', 'advert_option_2', 'order_id', 'order_package', 'id', 'SET NULL', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('advert_option_2');
    }
}
