<?php

namespace common\modules\search\drivers\PSG\models;

use yii;
use yii\db\Expression;
use yii\db\Query;

class SearchDataRepository
{

    /**
     * @param int $entityId
     * @param int $modelId
     * @param string $string
     */
    public function add(int $entityId, int $modelId, string $string, array $index)
    {
        $sql = Yii::$app->db->createCommand()->insert(SearchData::tableName(), [
            'entity_id' => $entityId,
            'model_id' => $modelId,
            'data' => $string,
            'index' => $index
        ])->rawSql;
        $sql .= ' ON CONFLICT(entity_id,model_id) DO UPDATE SET data = EXCLUDED.data, index =EXCLUDED.index ';
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @param string $class
     * @param int $limit
     * @return array
     */
    public function getUnIndexItems(string $class, int $limit = 100)
    {
        return $class::find()
            ->leftJoin(SearchData::tableName() . ' as d', $class::tableName() . '.id = d.entity_id')
            ->where('d.entity_id IS NULL')
            ->limit($limit)
            ->all();
    }

    /**
     * @param string $string
     * @param array $wordIds
     * @return $this
     */
    public function search(string $string, array $wordIds)
    {
        return (new Query())
            ->select([
                'entity_id',
                'model'
            ])
            ->from(SearchData::tableName())
            ->innerJoin(SearchModels::tableName() . ' as sm', 'sm.id = model_id')
            ->where(new Expression("index && '{" . implode(',', $wordIds) . "}'"))
            ->orderBy(new Expression('similarity(data, :data) DESC', [
                'data' => $string
            ]));;

    }
}
