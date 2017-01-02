<?php

namespace common\models\menu;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use common\models\menu\MenuQuery;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $url
 */
class Menu extends \yii\db\ActiveRecord
{
    private $_parent;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['lft', 'rgt', 'depth', 'parent'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => 'Name',
            'url' => 'Url',
        ];
    }
    
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
    
    public function getParent(){
        if($this->_parent){
            return $this->_parent;
        }
        $parent = $this->parents(1)->one();
        return $parent ? $parent->id : '';
    }
    
    /**
     * 
     * @param string $data
     */
    public function setParent($data){
        $this->_parent = $data;
    }
}
