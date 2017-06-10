<?php
namespace common\modules\address\migrations;

use yii\db\Migration;

class m170427_203019_create_table_address extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'type' => $this->string(150)->notNull(),
            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255)->notNull(),
            'transliterate' => $this->string(150),
            'data' => 'json',
            'point' => 'geography NOT NULL',
            'longitude' => $this->double(53)->notNull()->comment('Долгота'),
            'latitude' => $this->double(53)->notNull()->comment('Широта'),
        ], $tableOptions);

        $this->execute('CREATE INDEX "address_point_idx" ON {{%address}} USING gist ("point")');
        $this->execute('CREATE INDEX "address_name_trgm_idx" ON "public"."address" USING gist ("name" "public"."gist_trgm_ops")');
    }

    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}
