<?php

namespace common\modules\search\drivers\PSG\models;

use common\modules\search\drivers\PSG\helpers\PsgHelper;
use yii;
use yii\db\Expression;
use yii\db\Query;

class SearchWordsRepository
{
    /**
     * @param array $words
     */
    public function add(array $words)
    {
        $sql = Yii::$app->db->createCommand()->batchInsert(SearchWords::tableName(), ['word'], PsgHelper::insertWordsTemplate($words))->rawSql;
        $sql .= ' ON CONFLICT DO NOTHING';

        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @param array $words
     * @return array
     */
    public function getIds(array $words)
    {
        return (new yii\db\Query())
            ->select(['id'])
            ->from(SearchWords::tableName())
            ->where([
                'word' => $words
            ])
            ->column();
    }

    /**
     * @param array $keywords
     * @return array
     */
    public function search(array $keywords)
    {
        $query = (new Query())
            ->select('id')
            ->from(SearchWords::tableName());

        foreach ($keywords as $key => $word) {
            $query->orWhere(new Expression("word % :word$key", [
                "word$key" => $word
            ]));
        }
        return $query->column();
    }
}
