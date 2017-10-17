<?php
/**
 * Created by PhpStorm.
 * User: befre
 * Date: 16.09.2017
 * Time: 15:31
 */

namespace common\models;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class PackageOptionsBehavior extends Behavior
{

    /**
     * @return array
     */
    public function events()
    {
        return [
//            ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate',
//            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
//            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
//            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
//            ActiveRecord::EVENT_INIT => 'afterInit',
        ];
    }

    public function afterSave()
    {
//        dd($this->owner);
    }

    }