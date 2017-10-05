<?php

namespace common\modules\taxonomy\models;

use common\helpers\URLify;
use yii\db\ActiveRecord;


class TaxonomyItems extends ActiveRecord
{

    const TABLE_TAXONOMY_ITEMS = 'taxonomy_items';

    /**
     * @var array
     */
    public $childrens = [];

    /**
     * @var array
     */
    private $_translations = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::TABLE_TAXONOMY_ITEMS;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['translations', 'icon_name'], 'safe'],
            [['vid', 'name'], 'required'],
            [['vid', 'pid', 'weight'], 'integer'],
            [['name', 'transliteration', 'icon_name'], 'string', 'max' => 50],
            [['vid', 'name'], 'unique', 'targetAttribute' => ['vid', 'name'], 'message' => 'The combination of Vid and Name has already been taken.'],
            [['name', 'vid'], 'unique', 'targetAttribute' => ['name', 'vid'], 'message' => 'The combination of Vid and Name has already been taken.'],
            [['icon'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \common\modules\file\components\FileBehavior::class,
            ]
        ];
    }

    /**
     * @return TaxonomyItemsQuery
     */
    public static function find()
    {
        return new TaxonomyItemsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->pid = $this->pid ? $this->pid : 0;
        $this->transliteration = $this->transliteration ? $this->transliteration : URLify::url($this->name);
        $this->data = [
            'translations' => $this->_translations
        ];
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vid' => 'Vid',
            'pid' => 'Pid',
            'name' => 'Name',
            'weight' => 'Weight',
            'icon_name' => 'Icon CSS class',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVocabulary()
    {
        return $this->hasOne(TaxonomyVocabulary::className(), ['id' => 'vid']);
    }

    /**
     * @param array $translations
     */
    public function setTranslations($translations)
    {
        $this->_translations = $translations;
    }

    /**
     * @return array
     */
    public function getTranslations(): array
    {
        return $this->data['translations'] ?? [];
    }

}
