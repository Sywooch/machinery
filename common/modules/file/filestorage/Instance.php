<?php
namespace common\modules\file\filestorage;

use common\modules\file\models\File as FileBase;
use common\modules\file\Finder;

class Instance extends FileBase implements InstanceInterface
{

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        Finder::deleteInstance($this);
        parent::delete();
    }
}
