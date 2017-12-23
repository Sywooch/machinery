<?php

use yii\db\Migration;

/**
 * Handles the creation of table `favorites`.
 */
class m171222_095042_create_favorites_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('favorites', [
            'id' => $this->primaryKey(),
            'entity_id' => $this->integer(11),
            'user_id' => $this->integer(11),
            'model' => $this->string(50)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('favorites');
    }
}
