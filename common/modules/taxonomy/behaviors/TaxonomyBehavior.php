<?php

namespace common\modules\taxonomy\behaviors;

use common\modules\taxonomy\helpers\TaxonomyHelper;
use common\modules\taxonomy\models\TaxonomyIndex;
use common\modules\taxonomy\models\TaxonomyIndexRepository;
use common\modules\taxonomy\models\TaxonomyItems;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class TaxonomyBehavior extends Behavior
{

    /**
     * @var array
     */
    private $_termFields = [];

    /**
     * @var TaxonomyIndexRepository
     */
    protected $_indexRepository;

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
            ActiveRecord::EVENT_INIT => 'afterInit',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterInit()
    {
        $this->_termFields = TaxonomyHelper::getTermAttributes($this->owner);
    }

    /**
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canGetProperty($name, $checkVars = true)
    {
        if (isset($this->_termFields[$name])) {
            if (!isset($this->$name)) {
                $this->$name = $this->owner->hasMany(TaxonomyItems::className(), ['id' => 'term_id'])->viaTable(TaxonomyIndex::tableName(), ['entity_id' => 'id'], function ($query) use ($name) {
                    $query->filterWhere(['field' => $name, 'model' => StringHelper::basename(get_class($this->owner))]);
                });
            }
            return true;
        }
        parent::canGetProperty($name, $checkVars);
    }

    /**
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canSetProperty($name, $checkVars = true)
    {
        if (isset($this->_termFields[$name])) {
            return true;
        }
        parent::canSetProperty($name, $checkVars);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (isset($this->_termFields[$name])) {
            $this->{$name} = $value;
            $this->owner->{$name} = $value;
        }
    }

    /**
     * Parsing term field data
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
            } elseif (is_array($data)) {
                $item = current(array_values($data));
                if ($item instanceof TaxonomyItems) {

                } elseif ((int)$item) {
                    $data = TaxonomyItems::findAll($data);
                }
            }
            $this->owner->{$attribute} = $data;
        }

    }

    /**
     * Add index info field. Run only on own model fields
     *
     * @return void
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
                if (isset($rule['type']) && $rule['type'] == 'integer') {
                    $this->owner->{$attribute} = $terms[0]->id;
                } else {
                    $this->owner->{$attribute} = ArrayHelper::getColumn($terms, 'id');
                }
            }
        }
    }

    /**
     * Save index to taxonomy index table. Run only on NOT own model fields
     *
     * @return void
     */
    public function afterSave()
    {

        $attributes = TaxonomyHelper::getTermAttributes($this->owner);
        $modelAttributes = $this->owner->attributes();
        foreach ($attributes as $attribute => $rule) {

            $terms = $this->owner->{$attribute};

            if (empty($terms)) {
                $this->_indexRepository->clear($this->owner, $attribute);
                continue;
            }

            if (!in_array($attribute, $modelAttributes)) {
                $this->_indexRepository->link($this->owner, $attribute, $terms);
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