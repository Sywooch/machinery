<?php

use yii\db\Migration;

class m171009_082025_create_table_advert_variant extends Migration
{
    public function up()
    {
        $this->createTable('advert_variant', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text(),
            'condition' => $this->integer(1),
            'operating_hours' => $this->integer(6),
            'mileage' => $this->integer(9),
            'bucket_capacity' => $this->text(),
            'status' => $this->boolean(),
            'maderated' => $this->boolean(),
            'lang' => $this->string(5),
            'advert_id' => $this->integer(11),
            'meta_description' => $this->string(255),
        ]);
    }

    public function down()
    {
        $this->dropTable('advert_variant');
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
