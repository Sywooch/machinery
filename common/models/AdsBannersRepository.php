<?php

namespace common\models;


class AdsBannersRepository
{

    /**
     * @param string $region
     * @param int|null $categoryId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findBanners(string $region, int $categoryId = null)
    {
       return  AdsBanners::find()
            ->innerJoin(AdsRegions::tableName() . ' r', 'r.id = region_id')
            ->filterWhere([
                'category_id' => $categoryId,
                'transliteration' => $region,
                'r.status' => AdsRegions::STATUS_ACTIVE,
                AdsBanners::tableName() . '.status' => AdsBanners::STATUS_ACTIVE
            ])
           ->orderBy([
               'weight' => SORT_ASC
           ])
            ->all();
    }
}
