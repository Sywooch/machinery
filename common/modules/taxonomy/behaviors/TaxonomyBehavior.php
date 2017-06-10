<?php

namespace common\modules\taxonomy\behaviors;

use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyIndex;
use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\taxonomy\models\TaxonomyIndexRepository;

class TaxonomyBehavior extends Behavior
{

    private $_indexRepository;

    /**
     * TaxonomyBehavior constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->_indexRepository = new TaxonomyIndexRepository();
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    /**
     *
     */
    public function afterValidate()
    {
        $attributes = TaxonomyHelper::getTermAttributes($this->owner);

        foreach ($attributes as $attribute => $rule) {

            $data = $this->owner->{$attribute};

            if (empty($data)) {
                continue;
            }

            if (is_string($data)) {
                $data = TaxonomyItems::findAll(explode(',', $data));
            } elseif ($data instanceof TaxonomyItems) {
                $data = [$this->owner->{$attribute}];
            }else{
                if((int)current(array_values($data))){
                    $data = TaxonomyItems::findAll($data);
                }
            }

            $this->owner->{$attribute} = $data;
        }

    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave()
    {
        $attributes = TaxonomyHelper::getTermAttributes($this->owner);
        $modelAttributes = $this->owner->attributes();
        foreach ($attributes as $attribute => $rule) {

            $terms = $this->owner->{$attribute};

            if (empty($terms)) {
                continue;
            }

            if (in_array($attribute, $modelAttributes)) {
                $this->owner->{$attribute} = ArrayHelper::getColumn($terms, 'id');
            }
        }
    }

    /**
     *
     */
    public function afterSave()
    {
        $attributes = TaxonomyHelper::getTermAttributes($this->owner);
        $modelAttributes = $this->owner->attributes();
        foreach ($attributes as $attribute => $rule) {

            $terms = $this->owner->{$attribute};

            if (empty($terms)) {
                continue;
            }

            if (!in_array($attribute, $modelAttributes)) {
                $this->_indexRepository->link($this->owner);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        TaxonomyIndex::deleteAll(['entity_id' => $this->owner->id, 'model' => StringHelper::basename(get_class($this->owner))]);
    }


    /**
     *
     * @param string $field
     * @return object
     */
    public function getTaxonomyItems($field = null)
    {
        return $this->owner->hasMany(TaxonomyItems::className(), ['id' => 'term_id'])->viaTable(TaxonomyIndex::tableName(), ['entity_id' => 'id'], function ($query) use ($field) {
            $query->filterWhere(['field' => $field, 'model' => StringHelper::basename(get_class($this->owner))]);
        });
    }

}

?>