<?php

namespace common\db;

use tigrov\pgsql\Schema as SchemaBase;
use common\modules\store\models\product\Product;

class Schema extends SchemaBase
{
    /**
     * @inheritdoc
     */
    public function insert($table, $columns)
    {
        if($table != Product::tableName()){
            return parent::insert($table, $columns);
        }

        $params = [];
        $sql = $this->db->getQueryBuilder()->insert($table, $columns, $params);

        $command = $this->db->createCommand($sql, $params);
        $command->prepare(false);
        $result = $command->queryOne();

        return ['id' => \Yii::$app->db->getLastInsertID()];
    }
}