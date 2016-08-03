<?php
namespace common\modules\import;

interface IndexerInterface
{
    
    public function add($item);
    public function flush();
    
}
