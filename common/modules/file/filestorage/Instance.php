<?php
namespace common\modules\file\filestorage;

use common\modules\file\models\File as FileBase;
use common\modules\file\filestorage\InstanceInterface;
use common\modules\file\Finder;

class Instance extends FileBase implements InstanceInterface{

    /**
     * 
     */
    public function delete() {
        Finder::deleteInstance($this);
        parent::delete();
    }
}
