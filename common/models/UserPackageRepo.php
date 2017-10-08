<?php

namespace common\models;

use yii\db\Expression;


class UserPackageRepo
{
    /**
     * @param User $user
     * @return mixed
     */
    public function getUserActivePackage(User $user)
    {
        return UserPackage::find()->andWhere(['user_id' => $user->id])->andWhere(['>', 'deadline', new Expression('NOW()')])->one();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getUserActivePackages(User $user)
    {
        return UserPackage::find()->andWhere(['user_id' => $user->id])->andWhere(['>', 'deadline', new Expression('NOW()')])->all();
    }


}
