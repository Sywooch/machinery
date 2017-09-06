<?php
/**
 * Виджет пакетов в форме объявления
 */

namespace frontend\widgets\Packages;

use Yii;
use yii\bootstrap\Widget;
use common\models\TarifPackages;
use common\models\OoptionsRepository;


class PackagesWidget extends Widget
{

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
        $model = TarifPackages::find()->where(['status'=>1])->orderBy(['weight'=>'asc'])->all();

        return $this->render('packages', [
            'model' => $model,
            'options' => $this->optionsRepository->getOptionsActive(),
        ]);
    }
}