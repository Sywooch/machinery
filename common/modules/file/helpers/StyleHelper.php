<?php

namespace common\modules\file\helpers;

use Yii;
use common\modules\file\models\File;
use yii\base\Object;

class StyleHelper extends Object
{

    const STYLE_DIR = 'style';

    /**
     * @var array
     */
    private $_resolution;

    /**
     * @var int
     */
    private $_fileId = false;

    /**
     * @var int
     */
    public $quality = 100;

    /**
     * @var int
     */
    public $height;

    /**
     * @var int
     */
    public $width;

    /**
     * @var bool
     */
    private $isValid = false;

    /**
     * StyleHelper constructor.
     * @param string $str
     */
    public function __construct($str = '')
    {
        if ($this->isStyleUrl($str)) {
            $this->_resolution = $this->getResolution($str);
            $this->height = $this->_resolution[2];
            $this->width = $this->_resolution[1];
            $this->_fileId = $this->getIdFromUrl($str);
            $this->isValid = true;
        } elseif ($this->isResolution($str)) {
            $this->_resolution = $this->getResolution($str);
            $this->height = $this->_resolution[1];
            $this->width = $this->_resolution[2];
        }

    }

    /**
     * @return int
     */
    public function getFileId()
    {
        return $this->_fileId;
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        if (!empty($this->_resolution)) {
            return $this->_resolution[0];
        }
        return '';
    }

    /**
     * @param $url
     * @return null
     */
    private function getIdFromUrl($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $data);
        if (key_exists('id', $data)) {
            return $data['id'];
        }
        return null;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return self::STYLE_DIR . '/' . $this->getName();
    }


    /**
     * @param File $file
     * @param $style
     * @return string
     */
    public static function getPreviewUrl(File $file, $style) : string
    {
        return $file->path . '/' . self::STYLE_DIR . '/' . $style . '/' . $file->name . '?token=' . FileHelper::getToken($file) . '&id=' . $file->id . '&t=' . time();
    }

    /**
     * @param $url
     * @return bool
     */
    private function isStyleUrl($url) : bool
    {
        $path = parse_url($url);
        if (!isset($path['query'])) {
            return false;
        }
        parse_str($path['query'], $params);
        if (strpos($path['path'], 'style') !== false
            && key_exists('token', $params)
            && key_exists('id', $params)
        ) {
            return true;
        }
        return false;
    }

    /**
     * @param $resolution
     * @return array|bool
     */
    public function isResolution($resolution)
    {
        $data = explode('x', $resolution);
        if (count($data) != 2) {
            return false;
        }
        return $data;
    }

    /**
     * @param null $resolution
     * @return string
     */
    public function getResolution($resolution = null)
    {

        if ($resolution === null) {
            return $this->width . 'x' . $this->height;
        }

        preg_match("/([0-9_]+)x([0-9_]+)/i", $resolution, $matches);
        return $matches;
    }


    /**
     * @return bool
     */
    public function validate()
    {
        return $this->isValid;
    }

}
