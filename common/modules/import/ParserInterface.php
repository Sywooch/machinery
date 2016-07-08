<?php
namespace common\modules\import;

use common\modules\import\models\Sources;

interface ParserInterface
{
    
    public function __construct(Sources $source);

    /**
     * 
     * @param array $data
     */
    public function sku(array $data);
    
    /**
     * 
     * @param array $data
     */
    public function title(array $data);
    
    /**
     * 
     * @param array $data
     */
    public function description(array $data);
    
    /**
     * 
     * @param array $data
     */
    public function price(array $data);
    
    /**
     * 
     * @param array $data
     */
    public function available(array $data);
    
}
