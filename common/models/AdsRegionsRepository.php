<?php

namespace common\models;


use yii\db\Query;

class AdsRegionsRepository
{

    /**
     * @return static[]
     */
    public function getRegions(){
        return AdsRegions::find()->all();
    }

    /**
     * @param AdsRegions $region
     * @param int $categoryId
     * @return int|string
     */
    public function countBanners(AdsRegions $region, int $categoryId = null){
        return (new Query())
            ->from(AdsBanners::tableName())
            ->filterWhere([
                'region_id' => $region->id,
                'category_id' => $categoryId
            ])
            ->count();
    }

}
