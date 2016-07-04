<?php

namespace console\modules\import\models;

use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
use common\modules\taxonomy\models\TaxonomyVocabulary;
/**
*
 */
class TemporaryTerms extends \yii\base\Model
{
    const TABLE_TMP_TERMS = 'tmp_terms';
    
    public $id;
    public $vocabulary_name;
    public $name;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vocabulary_name', 'name'], 'required'],
            [['id', 'vocabulary_name'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 50]
        ];
    }
    
    public function __construct() {
       $this->create();
       $this->fill();
    }


    public function fill(){
        Yii::$app->db->createCommand('
             INSERT IGNORE INTO '.self::TABLE_TMP_TERMS.' (id, pid, vid, vocabulary_name, name)'
                . '  SELECT t.id, t.pid, t.vid, v.name, t.name FROM '.TaxonomyItems::TABLE_TAXONOMY_ITEMS.' t '
                . 'INNER JOIN '.TaxonomyVocabulary::TABLE_TAXONOMY_VOCABULARY.' v ON v.id = t.vid'
                )->execute();
    }
    
    public function create(){

        return Yii::$app->db->createCommand('
            CREATE TEMPORARY TABLE IF NOT EXISTS '.self::TABLE_TMP_TERMS.' (
                `id` INT(11) NOT NULL,
                `pid` INT(11) NOT NULL,
                `vid` INT(11) NOT NULL,
                `vocabulary_name` VARCHAR(20) NOT NULL,
                `name` VARCHAR(50) NOT NULL,
                UNIQUE INDEX `v_i_n` (`vocabulary_name`, `name`)
            )
            ENGINE=MEMORY
            ROW_FORMAT=FIXED')
            ->execute();
    }
    
    public static function getTermIds(array $data){
        $query = (new \yii\db\Query())
            ->select(['id', 'pid', 'vid'])
            ->from(self::TABLE_TMP_TERMS);
 
            foreach($data as $vocabulary => $terms){
                $query->orWhere([
                    'vocabulary_name' => $vocabulary,
                    'name' => array_keys($terms)
                    ]);
            }
           
            return $query->indexBy('id')->all();
    }

}
