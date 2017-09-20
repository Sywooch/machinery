<?php

namespace common\models;
use common\models\UserPackage;
/**
 * This is the ActiveQuery class for [[UserPackage]].
 *
 * @see UserPackage
 */
class UserPackageRepo extends UserPackage
{
    /**
     * @param null $user_id
     * @return array|\common\models\UserPackage|null действующий пакет для юзера
     */
    public function activePackage($user_id=null)
    {
        $user_id = $user_id ? $user_id : \Yii::$app->user->id;
        return parent::find()->andWhere(['user_id'=>$user_id])->andWhere(['>', 'deadline', time()])->one();
    }

    /**
     * @param null $user_id
     * @return array|UserPackage[] действующие пакеты для юзера
     */
    public function activePackages($user_id=null)
    {
        $user_id = $user_id ? $user_id : \Yii::$app->user->id;
        return parent::find()->andWhere(['user_id'=>$user_id])->andWhere(['>', 'deadline', time()])->all();
    }



}
