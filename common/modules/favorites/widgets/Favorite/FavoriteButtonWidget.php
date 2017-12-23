<?php

namespace common\modules\favorites\widgets\Favorite;

use yii;
use yii\bootstrap\Widget;
use common\modules\favorites\models\FavoritesRepository;

class FavoriteButtonWidget extends Widget
{

    /**
     * @var FavoritesRepository
     */
    private $_repository;

    public $model;
    public $classBtn = '';
    public $classIcon = '';


    public function __construct(FavoritesRepository $repository, $config = array())
    {
        $this->_repository = $repository;
        parent::__construct($config);
    }

    public function run()
    {
        return $this->render('favorite-button',
            [
                'model' => $this->model,
                'classBtn' => $this->classBtn,
                'classIcon' => $this->classIcon,
                'count' => Yii::$app->user->id ? $this->_repository->check($this->model->id, \yii\helpers\StringHelper::basename(get_class($this->model)), Yii::$app->user->id) : 0]);
    }
}
