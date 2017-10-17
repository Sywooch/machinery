<?php
/**
 * Виджет пакетов в форме объявления
 */

namespace frontend\widgets\Packages;

use common\models\OrderPackage;
use Yii;
use yii\bootstrap\Widget;
use common\models\TarifPackages;
use common\models\OoptionsRepository;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


class PackagesWidget extends Widget
{
    /**
     * @var advert
     */
    public $advert;

    /**
     * @var optionsRepository
     */
    public $optionsRepository;

    public function __construct(TarifPackages $model, OoptionsRepository $optionsRepository, $config = array())
    {
        $this->optionsRepository  = $optionsRepository;
        parent::__construct($config);
    }

    public function run()
    {
        // Доступные пакеты
        $model = TarifPackages::find()->where(['status'=>1])
            ->with('optionsPack')
            ->indexBy('id')
            ->orderBy(['weight'=>'asc'])->all();

        // Пакеты, которые юзер оплатил или заказал

        $package = OrderPackage::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['>', 'deadline', new Expression("NOW()")])
//            ->andWhere(['status'=> Yii::$app->params['order_statuses']['active']])
            ->andWhere(['not',['package_id'=>null]])
            ->asArray()
            ->one();

        return $this->render('packages', [
            'model' => $model,
            'advert' => $this->advert,
            'options' => $this->optionsRepository->getOptionsActive(),
            'package' => $package,
        ]);
    }
}