<?php
use yii\jui\AutoComplete;
use yii\web\JsExpression;

?>

<form id="search-from" method="get" action="<?=$action?>">
    <div class="input-group ">
        <?= AutoComplete::widget([
            'name' => 's',
            'id' => 'search-input',
            'value' => trim(Yii::$app->request->get('s')),
            'clientOptions' => [
                'source' => [],
                'autoFill' => true,
                'minLength' => '2',
                'select' => new JsExpression("function( event, ui ) {
               // $('#user-company').val(ui.item.id);
            }")
            ],
            'options' => ['class' => 'form-control ui-autocomplete-input', 'placeholder' => 'Я шукаю...']
        ]);
        ?>

        <div class="input-group-btn">
            <button type="submit" class="btn btn-default glyphicon glyphicon-search"></button>
        </div>
    </div>
</form>


