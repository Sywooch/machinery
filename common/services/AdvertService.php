<?php

namespace common\services;


use common\models\Advert;
use common\models\AdvertOption;
use common\models\AdvertOptionRepository;
use common\models\TarifPackagesRepository;
use common\models\UserPackageRepo;
use common\service\exeptions\UserHasNotPackageException;
use Yii;
use yii\helpers\ArrayHelper;

class AdvertService
{
    /**
     * @var AdvertOptionRepository
     */
    protected $advertOptionRepository;

    /**
     * @var UserPackageRepo
     */
    protected $userPackageRepository;

    /**
     * AdvertService constructor.
     * @param AdvertOptionRepository $advertOptionRepository
     * @param UserPackageRepo $userPackageRepository
     */
    function __construct(AdvertOptionRepository $advertOptionRepository, UserPackageRepo $userPackageRepository)
    {
        $this->advertOptionRepository = $advertOptionRepository;
        $this->userPackageRepository = $userPackageRepository;
    }

    /**
     * @param Advert $advert
     * @return bool
     * @throws UserHasNotPackageException
     */
    public function save(Advert $advert)
    {

        $userPackage = $this->userPackageRepository->getUserActivePackage(Yii::$app->user->identity);

        if (!$userPackage) {
            throw new UserHasNotPackageException('User has no one package');
        }

        if ($advert->isNewRecord) {

            if (!$advert->save()) {
                return false;
            }

            foreach ($userPackage->package->optionsPack as $option) {
                $advert->link('options', $option);
            }

            return true;
        }
        return $advert->save();
    }

    /**
     * @param Advert $advert
     * @return bool
     */
    public function updateOptions(Advert $advert){

        $options = AdvertOption::findAll($advert->getAdvertOrderOptions());

        if (!$options) {
            return false;
        }

        foreach ($options as $option) {
            $advert->link('options', $option);
        }
        $advert->order_options = null;
        $advert->save();
        return true;
    }
}