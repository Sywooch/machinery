<?php

namespace frontend\widgets\AdsBanners;

use common\models\AdsBannersRepository;
use yii\bootstrap\Widget;

class AdsBannersWidget extends Widget
{
    /**
     * @var string
     */
    public $region;

    /**
     * @var AdsBannersRepository
     */
    public $bannersRepository;

    /**
     * AdsBannersWidget constructor.
     * @param AdsBannersRepository $bannersRepository
     * @param array $config
     */
    public function __construct(AdsBannersRepository $bannersRepository, array $config = [])
    {
        $this->bannersRepository = $bannersRepository;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('index', [
            'region' => $this->region,
            'models' => $this->bannersRepository->findBanners($this->region),
        ]);
    }
}