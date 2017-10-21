<?php
namespace frontend\widgets\Language;
use Yii;
use common\modules\language\models\LanguageRepository;
/**
 *
 */

class LanguageSwitcher extends \yii\base\Widget
{
    public $data;
    public $languageRepository;

    public function __construct(LanguageRepository $languageRepository, $config = array())
    {
        $this->languageRepository = $languageRepository;
        parent::__construct($config);
    }

    public function run()
    {
//        dd($this->languageRepository);
        return $this->render('switcher', [
            'model' => $this->languageRepository->loadAllActive(),
        ]);
    }
}