<?php

namespace common\modules\favorites;

use yii\base\InvalidParamException;
use yii;
use common\modules\favorites\models\FavoritesRepository;
use common\modules\favorites\models\FavoritesCategoryRepository;
use yii\data\ActiveDataProvider;

class Favorite
{
    /**
     * @var FavoritesRepository
     */
    private $_repository;

    /**
     * @var FavoritesCategoryRepository
     */
    private $_categoryRepository;

    /**
     * Favorite constructor.
     * @param FavoritesRepository $repository
     * @param FavoritesCategoryRepository $categoryRepository
     */
    public function __construct(FavoritesRepository $repository, FavoritesCategoryRepository $categoryRepository)
    {
        $this->_repository = $repository;
        $this->_categoryRepository = $categoryRepository;
    }

    /**
     * @return FavoritesRepository
     */
    public function getRepository()
    {
        return $this->_repository;
    }

    /**
     * @param array $params
     * @return array|yii\db\ActiveRecord[]
     */
    public function find(array $params)
    {
        return new ActiveDataProvider([
            'query' => $this->_repository->find($params),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    /**
     * @param int $entityId
     * @param string $model
     * @return bool|int
     */
    public function touch(int $entityId, string $model)
    {
        if (($id = $this->_repository->check($entityId, $model, Yii::$app->user->id))) {
            $this->_repository->remove($id);
            return true;
        }
        $this->_repository->add(Yii::$app->user->id, $entityId, $model);
        return Yii::$app->db->getLastInsertID();
    }


    /**
     * @param int $favoriteId
     * @param int $categoryId
     * @return bool|string
     * @throws InvalidParamException
     */
    public function touchCategory(int $favoriteId, int $categoryId)
    {
        $model = $this->_repository->getById($favoriteId);

        if (!$model) {
            throw new InvalidParamException();
        }

        if (($id = $this->_categoryRepository->check($model, $categoryId))) {
            $this->_categoryRepository->remove($id);
            return true;
        }
        $this->_categoryRepository->add($model, $categoryId);
        return Yii::$app->db->getLastInsertID();
    }

}