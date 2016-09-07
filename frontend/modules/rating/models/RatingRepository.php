<?php

namespace frontend\modules\rating\models;

use Yii;
use frontend\modules\rating\models\Rating;

class RatingRepository 
{
    public function getAvgRating(array $params){
        $query = (new \yii\db\Query())
                ->from(Rating::tableName())
                ->where($params);
        
        return $query->average('rating');
    }
}
