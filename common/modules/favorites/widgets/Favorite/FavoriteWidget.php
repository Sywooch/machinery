<?php

namespace common\modules\favorites\widgets\Favorite;

use yii;
use yii\bootstrap\Widget;
use common\modules\favorites\models\FavoritesRepository;

class FavoriteWidget extends Widget
{

    /**
     * @var FavoritesRepository
     */
    private $_repository;

    public function __construct(FavoritesRepository $repository, $config = array())
    {
        $this->_repository = $repository;
        parent::__construct($config);
    }

    public function run()
    {
        return $this->render('favorite', ['count' => Yii::$app->user->id ? $this->_repository->count(Yii::$app->user->id) : 0]);
    }
}
