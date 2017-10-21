<?php

namespace common\modules\search;

use yii\db\ActiveRecord;

interface DriverIndex
{
    /**
     * @param ActiveRecord $entity
     * @param array $fields
     * @return mixed
     */
    public function add(ActiveRecord $entity, array $fields);

    /**
     * Start indexing content for search
     * @return mixed
     */
    public function run();
}