<?php

namespace common\modules\store\classes;

interface UrlInterface {
    public function getFilterTerms();
    public function getCatalogPath();
    public function getMin();
    public function getMax();
    public function getMain();
    public function getCategory();
    public function validate();
    public function getTerms(array $except = []);
}