<?php

use yii\db\Migration;

/**
 * Handles the creation of table `packages`.
 */
class m170801_125200_create_packages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tarif_packages', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'sub_caption' => $this->string(),
            'description' => $this->text(),
            'price'=> $this->decimal(6,2),
            'term' => $this->integer(3),
            'options' => $this->text(),
            'weight' => $this->integer(3),
            'status' => $this->boolean(),
        ]);

        $this->createTable('tarif_options', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'price'=> $this->decimal(6,2),
            'term' => $this->integer(3),
            'weight' => $this->integer(3),
            'status' => $this->boolean(),
            'term_advert' => $this->integer(3),
            'quantity' => $this->integer(3),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tarif_packages');
        $this->dropTable('tarif_options');
    }
}
