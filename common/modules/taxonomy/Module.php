<?php

namespace common\modules\taxonomy;

class Module extends \yii\base\Module
{
    private $_languages = [];

    /**
     *
     */
    public function init()
    {
        parent::init();

    }

    /**
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->_languages ?? [];
    }

    /**
     * @param array $languages
     */
    public function setLanguages($languages)
    {
        if ($languages instanceof \Closure) {
            $this->_languages = ($languages)();
            return;
        }
        $this->_languages = $languages;
    }
}
