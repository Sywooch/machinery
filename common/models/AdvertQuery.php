<?php

namespace common\models;
use common\modules\search\drivers\PSG\helpers\PsgHelper;
use common\modules\search\drivers\PSG\models\SearchData;
use common\modules\taxonomy\models\TaxonomyIndex;
use frontend\models\FilterForm;

/**
 * This is the ActiveQuery class for [[Advert]].
 *
 * @see Advert
 */
class AdvertQuery extends \yii\db\ActiveQuery
{

    /**
     * @param FilterForm $filterForm
     * @return $this
     */
    public function category(FilterForm $filterForm)
    {
        if($filterForm->category){
            $this->innerJoin(TaxonomyIndex::tableName().' category','category.entity_id = '.Advert::tableName().'.id');
        }

        return $this->andFilterWhere(['category.term_id' => $filterForm->category]);
    }

    /**
     * @param FilterForm $filterForm
     * @return $this
     */
    public function manufacturer(FilterForm $filterForm)
    {
        if($filterForm->manufacturer){
            $this->innerJoin(TaxonomyIndex::tableName().' manufacturer','manufacturer.entity_id = '.Advert::tableName().'.id');
        }

        return $this->andFilterWhere(['manufacturer.term_id' => $filterForm->manufacturer]);
    }

    /**
     * @param FilterForm $filterForm
     * @return $this
     */
    public function country(FilterForm $filterForm)
    {
        if($filterForm->country){
            $this->innerJoin(TaxonomyIndex::tableName().' country','country.entity_id = '.Advert::tableName().'.id');
        }
        return $this->andFilterWhere(['country.term_id' => $filterForm->country]);
    }

    /**
     * @param FilterForm $filterForm
     * @return $this
     */
    public function price(FilterForm $filterForm)
    {
        return $this->andFilterWhere(['<=', 'price', $filterForm->price['max']])->andFilterWhere([ '>=', 'price', $filterForm->price['min']]);
    }

    /**
     * @param FilterForm $filterForm
     * @return $this
     */
    public function model(FilterForm $filterForm)
    {
        return $this->andFilterWhere(['model'=> $filterForm->model]);
    }

    /**
     * @param FilterForm $filterForm
     * @return $this
     */
    public function id(FilterForm $filterForm)
    {
        return $this->andFilterWhere(['id'=> $filterForm->id]);
    }

    /**
     * @param FilterForm $filterForm
     * @return $this
     */
    public function year(FilterForm $filterForm)
    {
        return $this->andFilterWhere(['year'=> $filterForm->year]);
    }

    /**
     * @param FilterForm $filterForm
     * @return $this
     */
    public function search(FilterForm $filterForm)
    {
        if(!$filterForm->search){
            return $this;
        }
        
        $search = (\Yii::$app->getModule('search'))->getSearch();

        $wordIds = $search->getWordsRepository()->search(PsgHelper::keywords(PsgHelper::searchStringProcess($filterForm->search)));
        $query = $search->getDataRepository()->search(PsgHelper::searchStringProcess($filterForm->search), $wordIds)->select(SearchData::tableName().'.entity_id');

        return $this->andWhere([Advert::tableName().'.id'=> $query]);
    }

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Advert[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Advert|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
