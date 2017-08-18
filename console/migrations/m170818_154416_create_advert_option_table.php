<?php

use yii\db\Migration;

/**
 * Handles the creation of table `advert_option`.
 */
class m170818_154416_create_advert_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('advert_option', [
            'id' => $this->primaryKey(),
            'advert_id' => $this->integer(11),
            'option_id' => $this->integer(11),
        ]);
//        $this->createIndex('FK_post_author', '{{%post}}', 'author_id');
        $this->addForeignKey(
            'FK_option_advert', 'advert_option', 'advert_id', 'advert', 'id', 'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_option_option', 'advert_option', 'option_id', 'tarif_options', 'id', 'SET NULL', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('advert_option');
    }
}
