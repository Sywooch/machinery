<?php
namespace frontend\widgets\CategoryMenu;
use Yii;
use common\modules\taxonomy\models\TaxonomyItems;
class CategoryMenuWidget extends \yii\base\Widget
{

    public function __construct( $config = array())
    {
        parent::__construct($config);
    }

    public function run()
    {
        $categories = TaxonomyItems::find()
            ->where(['vid' => 2])
            ->andWhere(['pid' => 0])
            ->select(['id', 'name', 'icon_name', 'transliteration', 'data'])
            ->orderBy(['weight' => SORT_ASC])
            ->all();
        return $this->render('category-menu', [
            'categories' => $categories,
        ]);
    }
}