<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ads_regions`.
 */
class m170807_092249_create_ads_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ads_regions', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'price_front' => $this->decimal(6, 2)->notNull(),
            'price_category' => $this->decimal(6, 2)->notNull(),
            'price_subcategory' => $this->decimal(6, 2)->notNull(),
            'status' => $this->integer(),
            'banner_count' => $this->integer()->notNull(),
            'transliteration' => $this->string(255)->null(),
            'size' => $this->string(255)->null(),
        ]);


        $this->createTable('ads_banners', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer()->notNull(),
            'category_id' => $this->integer(),
            'url' => $this->string(255)->notNull(),
            'status' => $this->integer(),
            'weight' => $this->integer(),
            'created' => $this->integer(),
            'updated' => $this->integer(),
        ]);

        $this->createIndex(
            'ads_banners_region_category_idx',
            'ads_banners',
            ['region_id', 'category_id']
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'ads_banners_region_category_idx',
            'ads_banners'
        );

        $this->dropTable('ads_regions');
        $this->dropTable('ads_banners');
    }
}
