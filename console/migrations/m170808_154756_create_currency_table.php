<?php

use yii\db\Migration;

/**
 * Handles the creation of table `currency`.
 */
class m170808_154756_create_currency_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('currency', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'code' => $this->string(50)->notNull(),
            'course' => $this->decimal(6,2),
            'default' => $this->boolean(),
            'active' => $this->boolean()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('currency');
    }
}
