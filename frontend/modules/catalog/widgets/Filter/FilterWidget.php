<?php
namespace frontend\modules\catalog\widgets\Filter;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyVocabulary;

class FilterWidget extends \yii\bootstrap\Widget
{
    public $search; 
    
    
    public function run()
    {
        
        $catalogTerm = [];
        $this->search->index = [11]; // TODO: delete
        $terms = TaxonomyItems::findAll($this->search->index);
  
        foreach($terms as $term){
            if($term->vid == Yii::$app->params['catalog']['vocabularyId']){
              $catalogTerm = $term;  
            }
        }
       
        if(empty($catalogTerm)){
            return;
        }

        $filterTerms = $this->getFilterTermsByTerm($catalogTerm);

        if(empty($filterTerms)){
            return;
        }
        
        $filterItemsCount = $this->search->getCountFilterTerms($terms);
        
        array_walk ( $filterTerms , function (&$item, $key)  use ($filterItemsCount){
            $item['items'] = 0;
            if(isset($filterItemsCount[$key])){
                $item['items'] = $filterItemsCount[$key];
            }
        });

        return $this->render('filter-widget', [
                'filterItems' => ArrayHelper::index($filterTerms,'id','vid'),
                'vocabularies' => TaxonomyVocabulary::find()->all(),
        ]);
    }
    
    private function getFilterTermsByTerm(TaxonomyItems $term){
        
        $filterTerms = Yii::$app->cache->get("filter:catalog:{$term->id}");

        if ($filterTerms === false) {

            $filterTermIds = $this->search->getFilterTermIds($term);
        
            if(!$filterTermIds){
                return;
            }

            $filterTerms = ArrayHelper::toArray(TaxonomyItems::findAll($filterTermIds), [
                TaxonomyItems::class => [
                    'id',
                    'name',
                    'vid' 
                ],
            ]);

            unset($filterTermIds);

            $filterTerms = ArrayHelper::index($filterTerms, 'id');
            
            Yii::$app->cache->set("filter:catalog:{$term->id}", $filterTerms, 3600);
        }
        
        return $filterTerms;
        
    }
}
