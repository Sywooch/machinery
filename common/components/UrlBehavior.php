<?php

namespace common\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\Alias;
use common\helpers\URLify;
use yii\helpers\StringHelper;

class UrlBehavior extends Behavior
{
    /**
     * @var
     */
    private $_alias;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    /**
     *
     * @return Alias
     */
    public function getUrl()
    {
        if ($this->_alias) {
            return $this->_alias;
        }

        if ($this->owner->alias) {
            return $this->owner->alias;
        }

        $this->_alias = $this->createAlias();
        return $this->_alias;
    }

    /**
     *
     * @return Alias
     */
    public function getGroupUrl()
    {
        if ($this->_alias) {
            return $this->_alias->group;
        }
        return $this->owner->groupAlias;
    }

    /**
     *
     * @return Alias
     */
    public function getAlias()
    {
        return $this->owner->hasOne(Alias::className(), ['entity_id' => 'id'])->where(['model' => StringHelper::basename(get_class($this->owner))]);
    }

    /**
     *
     * @return Alias
     */
    public function getGroupAlias()
    {
        return $this->owner->hasOne(Alias::className(), ['entity_id' => 'group'])->where(['model' => Alias::GROUP_MODEL]);
    }

    /**
     *
     */
    public function afterDelete()
    {
        Alias::deleteAll(['entity_id' => $this->owner->id, 'model' => StringHelper::basename(get_class($this->owner))]);
    }

    /**
     *
     * @return Alias
     */
    private function createAlias()
    {

        if ($this->alias->one()) {
            return $this->alias;
        }

        $alias = \Yii::createObject([
            'class' => Alias::class,
            'entity_id' => $this->owner->id,
            'url' => null,
            'alias' => null,
            'model' => StringHelper::basename(get_class($this->owner)),
        ]);

        $alias = method_exists($this->owner, 'urlPattern') ? $this->owner->urlPattern($alias) : $this->urlPattern($alias);
        if ($alias->url == null) {
            $alias->url = strtolower(StringHelper::basename(get_class($this->owner))) . '/default' . '?id=' . $this->owner->id . '&model=' . StringHelper::basename(get_class($this->owner));
        }

        $alias->save();
        return $alias;
    }

    /**
     *
     * @param \common\models\Alias $alias
     * @return \common\models\Alias
     */
    public function urlPattern(\common\models\Alias $alias)
    {
        $alias->alias = URLify::url($this->owner->title);
        return $alias;
    }

}

?>