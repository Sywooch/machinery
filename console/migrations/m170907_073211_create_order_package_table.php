<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_package`.
 */
class m170907_073211_create_order_package_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_package', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'package_id' => $this->integer(11),
            'options' => $this->text(),
            'status' => $this->integer(2)->defaultValue(0),
            'cost' => $this->decimal(6,2),
            'create_at' => $this->timestamp(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_package');
    }
}
