<?php

use yii\db\Migration;

/**
 * Handles the creation of table `advert`.
 */
class m170807_124554_create_advert_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('advert', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text(),
            'price'=> $this->decimal(6,2),
            'currency' => $this->integer(),
            'website' => $this->string(255)->notNull(),
            'manufacture' => $this->string(255),
            'phone' => $this->string(255),
            'model' => $this->string(255),
            'year'=> $this->integer(6),
            'condition' => $this->integer(1),
            'operating_hours' => $this->integer(6),
            'mileage' => $this->integer(9),
            'bucket_capacity' => $this->text(),
            'tire_condition' => $this->text(),
            'serial_number' => $this->text(),
            'created' => $this->dateTime(),
            'updated' => $this->dateTime(),
            'published' => $this->dateTime(),
            'status' => $this->boolean(),
            'maderated' => $this->boolean(),
            'lang' => $this->string(5),
            'parent' => $this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('advert');
    }
}
