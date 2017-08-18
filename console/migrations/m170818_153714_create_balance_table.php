<?php

use yii\db\Migration;

/**
 * Handles the creation of table `balance`.
 */
class m170818_153714_create_balance_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('balance', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'date_action' => $this->timestamp(), // дата и время операции
            'type' => $this->integer(1), // тип - пополнение или снятие
            'summ_action' => $this->decimal(12,2), // сумма
            'balance_prev' => $this->decimal(12,2), // остаток до операции
            'balance' => $this->decimal(12,2), // остаток после операции
        ]);

        $this->addForeignKey(
            'FK_balance_user', 'balance', 'user_id', 'user', 'id', 'SET NULL', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('balance');
    }
}
