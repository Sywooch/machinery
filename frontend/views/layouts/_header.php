<?php

use frontend\widgets\SearchForm\SearchFormWidget as SearchForm;
use common\modules\store\widgets\Compare\CompareWidget;
use common\modules\store\widgets\Wish\WishWidget;
use common\modules\store\widgets\CartBlock\CartBlockWidget as CartBlock;
use yii\helpers\Html;
use common\modules\store\widgets\CatalogMenu\CatalogMenuWidget as CatalogMenu;
?>

<div class="l1">
    <div class="container">
        <ul class=" h-menu">
            <li class=" "><a href="/" title="" class="active">Главная </a></li>
            <li class=""><a href="/catalog" title="">Каталог </a></li>
            <li class=""><a href="/ru/news" title="">Новости </a></li>
            <li class=""><a href="/ru/reviews" title="">Отзывы</a></li>
            <li class=""><a href="/ru/faq" title="">FAQ </a></li>
            <li class=""><a href="/ru/oplata">Оплата</a></li>
            <li class=""><a href="http://vinbike.com.ua/ru/skidki" title="Скидки">Скидки</a></li>
            <li class=""><a href="/ru/contacts" title="">Контакты</a></li>
        </ul>
        <?= $this->render('_login'); ?>
    </div>
</div>
<div class="l2">
    <div class="container">

        <div class="row">
            <div class="col-lg-2">
                <a class="logo"></a>
            </div>
            <div class="col-lg-6">
                <ul class="phones">
                    <li>
                        <img width="27" height="29" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAAdCAIAAADU74AfAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QzU2OUVCRDM0Q0EzMTFFNjk2QTU5N0M2NTVFOTBEQjQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QzU2OUVCRDQ0Q0EzMTFFNjk2QTU5N0M2NTVFOTBEQjQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpDNTY5RUJEMTRDQTMxMUU2OTZBNTk3QzY1NUU5MERCNCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpDNTY5RUJEMjRDQTMxMUU2OTZBNTk3QzY1NUU5MERCNCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PtNC6igAAARISURBVHjaxFZdaBxVFD7fndlkNzubpF02fzVqpT4JtWIrBUHTaqVFK9I3RaRPpQ9BBX3QakW0BKsiLUgViYIVWsEH+yIoPqhV0BdrkWot5EfblCXpZv+yyWZ3Z+7x3J3ZzWyyViiC87Cwd+75zjnf991zB8xM/+mD/wORK6RzpBcJnWQlCbEbQtQFKv/CpW9o8VuqTZBXkiXZTKqLOjZybLtKPEjRbWSnzOK/I1Yu8twRLP1AXk4qXBNi1kjFKbaVUy+g695VoKsQPV48y1cPqFra7APX67JJu+1wmeHQwFH0PkGItEPkMudP8exL0CXAAHDkZnIepcgw16ZU4TPysvWIVlC2kXqOkk+T1bMakRc+p6uj4GKwW3Xz0Ak4DxNs4ipVzvOfj4DLbShAlFOHkXwmiGtIkadrb6/AEXtWH+I7DJzJ20HReyh6d4PFFt6MGeaPU3UqhMhaz72G5V+DTiiiYyMq9TwppyVWRUPStKK6c5weNQ7zu+bKHzS1s14gtNWDwXeQeMzUFX68LE/cBZ1dgWOfVN8MImInDZ+Gs6ve1NL3oDIjSok9auAo2UNELi+codKXSOxjexC1v3j2VXjzZBTzRbuFhBMxfPk8ls4S14AqL/1Izk7DOpcvELu0/iCkU9nEFT1/jDLvKiG3+IWRSIypi2zgWDxF9iYS0WLbDMtenjNvUfYEyKXlC6RLivSScV/3PvS/buCEx+IZlTkGL2+q0Xm4l8ELgF+e+eHELsS2BqJZveh9EuIzeWrT5BVtU1HXZpUcDXZUL9LcEeIS1BqbGMXvpPgD1L03bGlxjznyRoSCdGyTFZckpHoDodMvQ1IBLWdO1tV6GnwDzm4pasVz/vvaFLnpeoArTdkEBxGnYfKvqPR1cPiaAXY/9TxuDobJqnn5Ny6cguA6e4y9qpM8ewhCNCDaCsd2aN4sUP4kDJxqFAaSQdB3CLHtxkxejnMnOTeupAlJm/2QrG7ULpuDJD0xsdUvwymEWJ3E8rn6O/Zpkypw07hoHRAy9wpyH5uUdU7gpqXZcDPo2ASr2w7RMU3uLBrW5fh9NDAWwIl1ro0h90lgb253FkXY2GZRKYRYmTCeMm+h4yNq6H2KbPDPKGc/wvx7BK9+iv3pgAYo/Bysougakb8h1dyZYHtkoxp4M4AzmX7m3AdijSDYOBINLDTnj+59ijrvoLAPILZiIUnxuv3UeXtTL84cV+6Vf5oR/hYZS1bfYb++0MSt/K6v7BeBcNt3UMH41OWfML0bpl9qdznU+7UGaMM4nJE2twKL1m4GzkPN7HrmgCp+2mL4VReDfSsNjiGxt8nA2ptLN6lgN81TO5Q70w5RwmyS3KkXEd0SPhH2mq0hrSqX4BXWXsgSxeji5EGVfHb1VL7+FwBXLlHhNFUm4WVYlyEz3FrHkWGKbaH4/TBjFDfwTaFFHdLLZgrAMmNGyTeFdZ2AvwUYAEHj8B5egmHVAAAAAElFTkSuQmCC">
                        <a href="tel:0633048686">(063) 304-86-86</a>
                    </li>
                    <li>
                        <img width="23" height="22" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAAWCAIAAACkFJBSAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDE2QkEzMjc0Q0EzMTFFNjg5OTlDMEYzNUZCNDYxQzYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDE2QkEzMjg0Q0EzMTFFNjg5OTlDMEYzNUZCNDYxQzYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpEMTZCQTMyNTRDQTMxMUU2ODk5OUMwRjM1RkI0NjFDNiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpEMTZCQTMyNjRDQTMxMUU2ODk5OUMwRjM1RkI0NjFDNiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pq9Nsi4AAAJMSURBVHja3FRLaxNRFD5z72Q0VdHWB7WJrbaiCCLSUhAbfOHCB6JWUKTirqJu3LhyKf4Bl8EnUqrFBlulFReGBkkRHwURocamaSQ0ltoWk7Qm9+kdkzYTOhkRXHmYuVzOfPOdc893zgXpaPcidMcT4h8mzjBNvVDGOMD6TjaZ01dgNnNex1DWUPlPoOizzNzkuCbByRD8C/v/WPShKX4nInZWaUdrUY27hFSJ4lkGwym1ysXRvmVF/1fx7rts34q0zY/JSNpl8gHfXS3P1UPrJrza0PLQSIp3x8TJjWjbyoLQM0T2xFlHFF4lETUDQWMV1fb25UIThjWIG/Ez9fyWz9C1kuBCwqVB2hFFc7ykdQ57qJYioivGA2MwkNSyovj54wm6vdJlRY+k+JaAapzC4ZYgvqdanqqDsw242Ls/qHyR4IE4BMfBt050HTCM0mIwCW0D5OU42l8DrXVwyIsr5w9uMwFCeX8/tibsdHWao78w2xn9yUQoSVXJFjwZanpmmbDFgy1FyzMCd+WupwUate7rzylPcy9RdIt/senda+9ZeNJUZyxtViE/3KNpE/l2ynX1DfvzBAST7Oangt7XmwDPg2405tnA/1l/nmBO1VV92dTLYxld7Y9toD0HXchy15wO0u64maO3gg8d19YuRTa5KNzlQZanqK1gt33YmqcS3t+iNyw3s0jM4QthLm1zmeVy1QPBALuxCB2RzWtsbsgP09zXBxmGMfCJNrQwbkWNVOmvvCaeh+T+F+pwUXdGqfcRuRgmVql+CTAACMHMFOEc87kAAAAASUVORK5CYII=">
                        <a href="tel:0633048686">(063) 304-86-86</a>
                    </li>
                    <li>
                        <img width="32" height="25" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAZCAIAAADfbbvGAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDdGMTgwMUQ0Q0EzMTFFNkEwODdGRDM0NkZBMjAwQUIiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDdGMTgwMUU0Q0EzMTFFNkEwODdGRDM0NkZBMjAwQUIiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpEN0YxODAxQjRDQTMxMUU2QTA4N0ZEMzQ2RkEyMDBBQiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpEN0YxODAxQzRDQTMxMUU2QTA4N0ZEMzQ2RkEyMDBBQiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Puad4AIAAANjSURBVHjatFZrSFNxFP/tobOtZi9rlDWVypyaWslS6GF9MIwKKulDhEEh0odAlLBAAz/YwyLID6VISFHO+ib0QATFMIyQWmUa1tBZPsrHdDqde5z+d25td941Kzr8GXf/e875nfe5IiLC/yRRcAD2/scI9B9h6INpEk4nlAqo1yBZgzUqiEX/AGCdxWcjrt6G7ikcEsaMEAkWhyEyAru3QaXEFJCVgaTNkIdBFACJBMnpJH0nnSyk5VoSJ5A4niTxpM2mKh11fqZpK1XX0foMEmsoLIn2n6aGFk5EiAIAdHSTOoPTO3dCE6noGlks7rev39GSrW7guaPcSrr6hQHY7PToKSfAybtORBpV1fIMPJjr0pvAO1IN3aoh66yfvnk56PqCA3noGXT/XRSKigvIOepNps0BlRYmK5cS8GWXyvHwOjJ3+t6JeRx2By5XomfAK7kjAYf28UqFPV7Mxd5tnDo/AJMF+WUYHQ+c5IYXJNvi8ZolVkONrcJJmpiktjeUftybhl9SpRW+jD4esAK/Uwub02tXSiz2pgkX3xIFtMm4W4a4KH7LiKB7hlGTUIi+DUHf7Waao6xdAat7jjZF49wJ/0ANjeJtpxCAoRfjk17tjDSbgs0BEXKOIFzukXL9mi0wGIUAxsyw2nj+spEQlGQyxEbxbhwOjIwLAdjsXBp8y2Xg+4LmmULGCyx7dNiFAJi9oSE8gOZXwbUzs7q/urR7jGM1rVAIAaxdDbmMF6L6Zhj7gwA0vUT/sDcBTCpMhkiVEECMGpGreB6YZ1BUDvNUQO0jY7hSBafIJ0QiLFcifoMQABu52Zn+NVffgst3IDjS7XZcuoW2Do/5Ps2/QR1gH4xPIOkw+oa9XePqQOzZjtJziI3hYsiup2eg70LBFbz/4j9sZBI01XA9GHDhPH6GMyWYnJlXjlLERXMxZOx9Q/jUA6vd33a2kwpPoazgtxvNMo28Yjx4zus4tzfkzSRPtecyKx33y7E0PNjKHDOh+CbuPcGUlQ8QeGtLxchIRUUJNqoXtpNnbaiuw/kbmLYHbwWm/Ww2SvO5CfgHS5/dt39ApQ6NbTAO+kwbn0CtVCI9GaePIXMXQqR/9dnCXOntx5sOtLajy4DBYW6crFjGzZ+0FKQmInod5It+o+CnAAMA0tQluzOp5qwAAAAASUVORK5CYII=">
                        <a href="tel:0633048686">(063) 304-86-86</a>
                    </li>
                </ul>
                <?=SearchForm::widget();?>
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
            <div class="col-lg-2">
                <?= CartBlock::widget();?>
                <?php //WishWidget::widget();?>
                <?php //CompareWidget::widget();?>
            </div>
        </div>

    </div>
</div>
<div class="l3">
    <?=CatalogMenu::widget(['vocabularyId' => Yii::$app->params['catalog']['vocabularyId']]);?>
</div>


