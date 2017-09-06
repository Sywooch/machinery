<?php
/**
 * Created by PhpStorm.
 * User: befre
 * Date: 06.09.2017
 * Time: 18:05
 */

namespace common\models;

use common\models\TarifOptions;


class OoptionsRepository extends TarifOptions
{

    public function getOptionsActive(){
        return TarifOptions::find()->where(['status'=>1])->orderBy(['weight'=>'asc'])->all();
    }
}