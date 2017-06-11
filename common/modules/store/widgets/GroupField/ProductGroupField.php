<?php

namespace common\modules\store\widgets\GroupField;

use common\modules\store\models\product\ProductRepository;
use yii\base\Widget;
use common\modules\taxonomy\models\TaxonomyItems;

class ProductGroupField extends Widget
{

    public $model, $attribute;

    /**
     * @var ProductRepository
     */
    protected $_repository;

    /**
     * ProductGroupField constructor.
     * @param ProductRepository $repository
     * @param array $config
     */
    public function __construct(ProductRepository $repository, array $config = [])
    {
        $this->_repository = $repository;
        parent::__construct($config);
    }

    public function run()
    {
        $attribute = $this->attribute;

        return $this->render('field', [
            'field' => $this,
            'entity' => $this->model->{$attribute} ? $this->_repository->getById($this->model->{$attribute}) : null
        ]);
    }

}
