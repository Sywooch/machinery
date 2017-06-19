<?php

namespace common\modules\language;

use common\modules\language\models\Message;
use yii;
use common\modules\language\models\SourceMessage;
use yii\i18n\DbMessageSource as DbMessageSourceBace;

class DbMessageSource extends DbMessageSourceBace
{
    public $forceInsert = false;

    private $_messages = [];

    /**
     * @inheritdoc
     */
    public function translate($category, $message, $language)
    {
        if ($this->forceInsert && $language === $this->sourceLanguage) {
            $sourceText = $this->translateMessage($category, $message, $language);
            if (!$sourceText) {
                $this->createSource($category, $message, $language);
            }
            return false;
        }
        return parent::translate($category, $message, $language);
    }

    /**
     * @inheritdoc
     */
    protected function translateMessage($category, $message, $language)
    {
        $key = $language . '/' . $category;
        return $this->_messages[$key][$message] ?? parent::translateMessage($category, $message, $language);
    }

    /**
     * @param $category
     * @param $message
     * @param $language
     * @return bool
     */
    private function createSource($category, $message, $language)
    {
        $sourceText = Yii::createObject([
            'class' => SourceMessage::class,
            'category' => $category,
            'message' => $message
        ]);
        $sourceText->save();

        $translate = Yii::createObject([
            'class' => Message::class,
            'id' => $sourceText->id,
            'language' => $language,
            'translation' => $message
        ]);
        $translate->save();

        $key = $language . '/' . $category;
        $this->_messages[$key][$message] = $sourceText;
        return true;
    }
}