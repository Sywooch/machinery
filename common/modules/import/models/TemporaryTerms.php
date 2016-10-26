<?php

namespace common\modules\import\models;

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
    public $data;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vocabulary_name', 'name', 'transliteration'], 'required'],
            [['id', 'vocabulary_name'], 'string', 'max' => 20],
            [['name', 'transliteration'], 'string', 'max' => 50]
        ];
    }
    
    public function __construct() {
       $this->create();
       $this->fill();
    }


    public function fill(){
        
        $data = Yii::$app->db->createCommand($sql = '  SELECT t.id, t.pid, t.vid, v.name as vocabulary_name, t.name, t.transliteration FROM '.TaxonomyItems::TABLE_TAXONOMY_ITEMS.' t '
                . 'INNER JOIN '.TaxonomyVocabulary::TABLE_TAXONOMY_VOCABULARY.' v ON v.id = t.vid '
                )->queryAll();
        
      
        foreach($data as $item){
            $this->data[$item['vocabulary_name']][$item['name']] = $item;
        }
        
       
        /*
        Yii::$app->db->createCommand($sql = '
             INSERT  INTO '.self::TABLE_TMP_TERMS.' (id, pid, vid, vocabulary_name, name, transliteration)'
                . '  SELECT t.id, t.pid, t.vid, v.name, t.name, t.transliteration FROM '.TaxonomyItems::TABLE_TAXONOMY_ITEMS.' t '
                . 'INNER JOIN '.TaxonomyVocabulary::TABLE_TAXONOMY_VOCABULARY.' v ON v.id = t.vid'
                )->execute();
         */
        
    }
    
    public function create(){
        /*
         Yii::$app->db->createCommand($sql = '
            CREATE TEMPORARY TABLE '.self::TABLE_TMP_TERMS.' (
                id INT NOT NULL,
                pid INT NOT NULL,
                vid INT NOT NULL,
                vocabulary_name VARCHAR(50) NOT NULL,
                name VARCHAR(50) NOT NULL,
                transliteration VARCHAR(50) NOT NULL,
                CONSTRAINT v_i_n UNIQUE  (vocabulary_name, name)
            )')
            ->execute();
         */
         
    }
    
    public function getTerms(array $data){
        if(empty($data)){
            return [];
        }
       
        $return = [];
        foreach($data as $vocabulary => $terms){
            foreach($terms as $term => $temp){
              if(isset($this->data[$vocabulary][$term])){
                  $return[] = $this->data[$vocabulary][$term];
              }  
            }
        }
        return $return;
       
        /*
        $query = (new \yii\db\Query())
            ->select(['id', 'pid', 'vid', 'name', 'vocabulary_name', 'transliteration'])
            ->from(self::TABLE_TMP_TERMS);
            $where = [];
            foreach($data as $vocabulary => $terms){
                $where[] = "vocabulary_name = '{$vocabulary}' AND name IN ('" . implode("','", array_keys($terms)) . "')";
            }
            $query->where('(' . implode(') OR (', $where) . ')');
            return $query->indexBy('id')->all();
        
         */
    }

}
