<?php
namespace common\modules\import\components;

use common\modules\import\models\Sources;
use common\modules\import\helpers\ImportHelper;
use common\modules\import\components\Insert;
use common\modules\import\models\Validate;
use common\modules\import\models\TemporaryTerms;
use yii\helpers\Console;

class Import{
    
    const MAX_IMPORT_ERRORS = 100;
    
    private $_helper;
    private $_insert;
    private $_fields = [];
    private $_validator;
    private $_temporaryTerms;
    private $_controller;


    public $sources;
    

    public function __construct($controller, Sources $source, ImportHelper $helper, Insert $insert, Validate $validator, TemporaryTerms $temporaryTerms) {
        $this->_controller = $controller;
        $this->_helper = $helper;
        $this->_insert = $insert;
        $this->_temporaryTerms = $temporaryTerms;
        $this->_validator = $validator;
        $this->_validator->temporaryTerms = $this->_temporaryTerms;
    } 
    
    
    public function run(){
        foreach($this->sources as $source){
            $this->_insert->init();
            $this->_validator->source = $source;
            $this->_controller->stdout("Source: {$source->name}\n", Console::FG_GREEN);
            
            if(!$source->open()){
                $this->_controller->stdout($source->addMessage("[1000] Файл не найден или не может быть прочитан.\n"), Console::FG_RED);
                continue;
            }
            while (($line = $source->read()) !== FALSE) {
                $this->_validator->setDefault();
                $line['terms'] = $this->parseTerms($line);
                $line['images'] = $this->parseImages($line);
                $this->_validator->setAttributes($line);
              
                if($this->_validator->validate()){
                    $this->_insert->add($this->_validator);
                }else{
                    foreach($this->_validator->getErrors() as $field => $errors){
                        foreach($errors as $error){
                            $this->_controller->stdout($source->addMessage("[1004] [{$this->_validator->sku}] {$field} {$error}\n"), Console::FG_RED);
                        }
                    }
                    if($source->countMessages() > self::MAX_IMPORT_ERRORS){
                        $this->_controller->stdout($source->addMessage("[1003] Превышен лимит максимального количества ошибок. Операции прекращены.\n"), Console::FG_RED);
                        break;
                    }
                }
            }
            $this->_insert->flush();
            $source->close();
            $source->save();
        }
    }


    
    
    public function parseTerms(array $data){
        return $this->_helper->parseTerms($data);
    }
    
    public function parseImages(array $data){
        return $this->_helper->parseImages($data);
    }
    
    public function getFields(){
        return $this->_fields;
    }

}
