<?php
use yii\helpers\Html;
?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <a href="/" class="logo">SMARTER</a>
            </div>
            <div class="col-lg-6">
                <div class="f-menu">
                    <h5 class="">
                        Про нас
                    </h5>
                    <ul class="">
                        <li class="">
                            <a href="/">Головна</a>
                        </li>
                        <li class="">
                            <a href="/">Відгуки</a>
                        </li>
                        <li class="">
                            <a href="/">Новини</a>
                        </li>
                        <li class="">
                            <a href="/">Про компанію</a>
                        </li>
                    </ul>
                </div>
                <div class="f-menu">
                    <h5 class="">
                        Інфомація
                    </h5>
                    <ul class="">
                        <li class="">
                            <a href="/">Новини</a>
                        </li>
                        <li class="">
                            <a href="/">Питання-відповіді</a>
                        </li>
                        <li class="">
                            <a href="/">Способи оплати</a>
                        </li>
                        <li class="">
                            <a href="/">Контакти</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="info">
                    <?=Html::button('Замовити дзвінок',['class' => 'btn btn-white']);?>
                    <ul class="work-time">
                        <li><span>Графік:</span> ПН-ПТ СБ-НД</li>
                        <li><span>роботи:</span> <strong>10-19</strong> &nbsp;&nbsp;<strong>10-18</strong></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
</footer>