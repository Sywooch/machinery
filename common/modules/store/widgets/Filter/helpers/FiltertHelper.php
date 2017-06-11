<?php

namespace common\modules\store\widgets\Filter\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\modules\store\components\StoreUrlRule;
use common\modules\taxonomy\models\TaxonomyItems;

class FiltertHelper
{

    /**
     * @param StoreUrlRule $url
     * @param array $term
     * @return string
     */
    public static function link(StoreUrlRule $url, array $term)
    {
        $terms = $url->filterTerms;
        $term = (object)$term;

        if (isset($terms[$term->id])) {
            unset($terms[$term->id]);
        } else {
            $terms[$term->id] = $term;
        }

        $return = [];
        foreach (ArrayHelper::map($terms, 'id', 'id', 'vid') as $vid => $ids) {
            $return[] = StoreUrlRule::TERM_INDICATOR . $vid . '-' . implode('-', $ids);
        }

        if (empty($return)) {
            return $url->catalogPath;
        }

        return $url->catalogPath . DIRECTORY_SEPARATOR . StoreUrlRule::FILTER_INDICATOR . DIRECTORY_SEPARATOR . implode('_', $return);
    }


}