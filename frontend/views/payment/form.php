<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Shopping cart');

?>
<div class="container page-payment">

    <h1 class="page-title"><?= $this->title; ?></h1>

    <div class="box-form">

        <div class="row row1">
            <div class="col-sm-12 col-md-10 col-lg-10 columns">

                <h4 style="text-align:left;">
                    To complete your secure online order, please enter your billing information below.<br>The billing
                    information should be exactly as it appears on your credit card statement.
                </h4>
            </div>
            <div style="margin-top:20px;" class="col-sm-12 col-md-2 col-lg-2 columns">
                <span id="siteseal"><script type="text/javascript"
                                            src="https://seal.godaddy.com/getSeal?sealID=wIdlekCEQ5gXSOh2BJxcVvcUfxqLlW0wYVXwDfCHd5lO2wBRh4N3Mxjh5E3n"></script></span>
            </div>

        </div>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'payform']]); ?>

        <div class="row row1">

            <div class="col-sm-12 col-md-6 col-lg-6 columns">

                <h4>Billing information</h4>
                <div id="card-type">
                    <?php
                    echo $form->field($order, 'cardtype')->dropDownList([
                        'Visa' => 'Visa',
                        'MasterCard' => 'MasterCard',
                        'Amex' => 'Amex'
                    ]);
                    ?>

                    <?php
                    echo $form->field($order, 'creditcard')->textInput([]);
                    ?>
                    <div id="expiration">
                        <label class="control-label">Expiration</label>
                        <?php
                        $month = ['' => 'Month'];
                        for ($i = 1; $i <= 12; $i++) {
                            $month[$i] = str_pad($i, 2, '0', STR_PAD_LEFT);
                        }
                        echo $form->field($order, 'month', ['template' => '{input}{error}'])->dropDownList($month);
                        ?>
                        <?php
                        $year = ['' => 'Year'];
                        for ($i = 2015; $i <= 2035; $i++) {
                            $year[$i] = $i;
                        }
                        echo $form->field($order, 'year', ['template' => '{input}{error}'])->dropDownList($year);
                        ?>
                        <?php
                        echo $form->field($order, 'ccv', ['template' => '{input}{error}'])->textInput(['placeholder' => 'cvc code']);
                        ?>
                    </div>
                </div>
                <?php
                echo $form->field($order, 'name')->textInput([]);
                ?>
                <?php
                echo $form->field($order, 'lastname')->textInput([]);
                ?>
                <?php
                echo $form->field($order, 'phone')->textInput([]);
                ?>
                <?php
                echo $form->field($order, 'email')->textInput([]);
                ?>
                <div id="agree">
                    <label class="control-label"></label>
                    <?php
                    echo $form->field($order, 'agree')
                        ->checkBox(['label' => '<div>I understand I can get a full refund of my purchase anytime before shipment.</div>', 'uncheck' => null, 'selected' => true]);
                    ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 columns">
                <h4>Shipping Address</h4>
                <?php
                echo $form->field($order, 'zip')->textInput([]);
                ?>
                <?php
                echo $form->field($order, 'country')->dropDownList($order->getCountryes());
                ?>
                <?php
                echo $form->field($order, 'statenoneusa')->textInput([]);
                ?>
                <?php
                echo $form->field($order, 'state')->dropDownList($order->getStates());
                ?>
                <?php
                echo $form->field($order, 'city')->textInput([]);
                ?>
                <?php
                echo $form->field($order, 'address1')->textInput([]);
                ?>
                <?php
                echo $form->field($order, 'address2')->textInput([]);
                ?>
                <div id="agree">
                    <label class="control-label"></label>
                    <?php
                    echo $form->field($order, 'agree')
                        ->checkBox(['label' => '<div>I understand I get the pre-order of mask in the fall 2015 and helmet in winter 2015.</div>', 'uncheck' => null, 'selected' => true]);
                    ?>
                </div>
            </div>

        </div>
        <div class="row row1 text-center">
            <?= Html::submitButton('buy now', ['class'=>'btn btn-lg btn-primary text-uppercase']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>