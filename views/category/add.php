<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Добавить категорию';
?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3>➕ Добавить категорию</h3></div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                
                <?= $form->field($model, 'name')->textInput()->label('Название категории') ?>
                
                <?= $form->field($model, 'type')->dropDownList(['income' => 'Доход', 'expense' => 'Расход'], ['prompt' => 'Выберите тип']) ?>
                
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="/index.php?r=category/index" class="btn btn-secondary">Отмена</a>
                
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
