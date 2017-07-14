<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\jui\Slider;
use yii\bootstrap\BootstrapPluginAsset;
use frontend\helpers\SiteHelper;


// Asset::register($this);

?>
<form action="" class="filter-form-inner">
                        <div class="row filter-form-row">
                            <div class="col-md-4">
                                <label for="">Section</label>
                                <select name="" id="" class="form-control input-lg">
                                    <option value="">Lorem ipsum.</option>
                                    <option value="">Deserunt, ullam.</option>
                                    <option value="">Ad, recusandae!</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Category</label>
                                <select name="" id="" class="form-control input-lg">
                                    <option value="">Lorem ipsum.</option>
                                    <option value="">Fugiat, voluptates!</option>
                                    <option value="">Incidunt, nulla.</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">manufacturer</label>
                                <select name="" id="" class="form-control input-lg">
                                    <option value="">Lorem ipsum.</option>
                                    <option value="">Ducimus, delectus.</option>
                                    <option value="">Numquam, eaque!</option>
                                </select>
                            </div>
                        </div>
                        <div class="row filter-form-row">
                            <div class="col-md-4">
                                <label for="">Model</label>
                                <select name="" id="" class="form-control input-lg">
                                    <option value="">Lorem ipsum.</option>
                                    <option value="">Dignissimos, unde.</option>
                                    <option value="">Doloribus, accusamus.</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Price (EUR):</label>
                                <?php
            echo Slider::widget([
                'clientOptions' => [
                    'range' => true,
                    'min' => 10, // минимально возможная цена
                    'max' => 10000, // максимально возможная цена
                    'values' => [20, 5000], // диапазон по умолчанию
                    'step' => 10,
                    'animate' => true

                ],
                'clientEvents' => [
                    'create' => 'function(event, ui){
                       
                        $(".ui-slider-handle").attr("title", "Это бегунок цены, двигай его, мы покажем варианты.");
                        
                    }',
                    'slide' => 'function(event, ui){
                        //changeSlider(ui)
                        //overPrice();
                    }',
                    'change' => 'function( event, ui){
                        //changeSlider(ui)
                        //overPrice();
                    }',
                    'stop' => 'function( event, ui){
                    
                        if(typeof priceSlideStop != "undefined"){
                            //priceSlideStop(event, ui);
                        }

                    }',

                ]
            ]);
            ?>
            <div id="over-price" class="over-price">
                <span class="op-left">
                    <span id="op-left-text">0</span> </span>-<span
                    class="op-right">
                    <span id="op-right-text">200</span>
            </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">year of creation:</label>
                                <select name="" id="" class="form-control input-lg">
                                    <option value="">Lorem ipsum.</option>
                                    <option value="">Nesciunt, atque.</option>
                                    <option value="">Cupiditate, vitae?</option>
                                </select>
                            </div>
                        </div>
                        <div class="row filter-form-row">
                            <div class="col-md-4">
                                <label for="">Section:</label>
                                <select name="" id=""  class="form-control input-lg">
                                    <option value="">Lorem ipsum.</option>
                                    <option value="">Dolores, placeat.</option>
                                    <option value="">Laboriosam, est.</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Category:</label>
                                <select name="" id=""  class="form-control input-lg">
                                    <option value="">Lorem ipsum.</option>
                                    <option value="">Et, hic.</option>
                                    <option value="">Cum, incidunt.</option>
                                </select>
                            </div>
                        </div>
                        <div class="row filter-form-row filter-action">
                            <div class="col-md-12 text-center"><button type="submit" class="btn btn-warning btn-lg">Show results <span id="filter-count-result">(17 568)</span></button></div>
                        </div>
                    </form>


