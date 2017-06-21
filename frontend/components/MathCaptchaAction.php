<?php

namespace frontend\components;

use yii\captcha\CaptchaAction;

class MathCaptchaAction extends CaptchaAction
{

    /**
     * @inheritdoc
     */
    protected function generateVerifyCode()
    {
        return mt_rand((int)$this->minLength, (int)$this->maxLength);
    }

    /**
     * @inheritdoc
     */
    protected function renderImage($code)
    {
        return parent::renderImage($this->getText($code));
    }

    protected function getText($code)
    {
        $code = (int)$code;
        $rand = mt_rand(min(1, $code - 1), max(1, $code - 1));
        $operation = mt_rand(0, 1);
        if ($operation === 1) {
            return $code - $rand . '  +  ' . $rand.'  =  ';
        } else {
            return $code - $rand . '  +  ' . $rand.'  =  ';
        }
    }

    /**
     * Renders the CAPTCHA image based on the code using ImageMagick library.
     * @param string $code the verification code
     * @return string image contents in PNG format.
     */
    protected function renderImageByImagick($code)
    {

        $backColor = $this->transparent ? new \ImagickPixel('transparent') : new \ImagickPixel('#' . str_pad(dechex($this->backColor), 6, 0, STR_PAD_LEFT));
        $foreColor = new \ImagickPixel('#' . str_pad(dechex($this->foreColor), 6, 0, STR_PAD_LEFT));

        $image = new \Imagick();
        $image->newImage($this->width, $this->height, $backColor);

        $draw = new \ImagickDraw();
        $draw->setFont($this->fontFile);
        $draw->setFontSize(30);
        $fontMetrics = $image->queryFontMetrics($draw, $code);

        $length = strlen($code);
        $w = (int) $fontMetrics['textWidth'] - 8 + $this->offset * ($length - 1);
        $h = (int) $fontMetrics['textHeight'] - 8;
        $scale = min(($this->width - $this->padding * 2) / $w, ($this->height - $this->padding * 2) / $h);
        $x = 50;
        $y = round($this->height * 27 / 40);
        for ($i = 0; $i < $length; ++$i) {
            $draw = new \ImagickDraw();
            $draw->setFont($this->fontFile);
            $draw->setFontSize( 15);
            $draw->setFillColor($foreColor);
            $image->annotateImage($draw, $x, $y, 0, $code[$i]);
            $fontMetrics = $image->queryFontMetrics($draw, $code[$i]);
            $x += (int) $fontMetrics['textWidth'] + $this->offset;
        }

        $image->setImageFormat('png');
        return $image->getImageBlob();
    }
}