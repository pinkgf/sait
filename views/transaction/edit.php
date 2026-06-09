<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Редактировать операцию';
?>

<div class="form-card">
    <h2 style="margin-bottom: 24px;"><i class="fas fa-edit"></i> Редактирование операции</h2>
    
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="form-group">
        <label>Тип операции</label>
        <?= Html::activeDropDownList($model, 'type', [
            'income' => '💰 Доход',
            'expense' => '💸 Расход',
        ], ['class' => 'form-control']) ?>
    </div>
    
    <div class="form-group">
        <label>Категория</label>
        <?php
        $allCategories = array_merge($incomeCategories, $expenseCategories);
        ?>
        <?= Html::activeDropDownList($model, 'category_id', 
            ArrayHelper::map($allCategories, 'id', 'name'), 
            ['class' => 'form-control', 'prompt' => 'Выберите категорию']
        ) ?>
    </div>
    
    <div class="form-group">
        <label>Сумма</label>
        <?= Html::activeTextInput($model, 'amount', ['class' => 'form-control', 'type' => 'number', 'step' => '0.01']) ?>
    </div>
    
    <div class="form-group">
        <label>Дата</label>
        <?= Html::activeInput('date', $model, 'transaction_date', ['class' => 'form-control']) ?>
    </div>
    
    <div class="form-group">
        <label>Описание</label>
        <?= Html::activeTextarea($model, 'description', ['class' => 'form-control', 'rows' => 3]) ?>
    </div>
    
    <div style="display: flex; gap: 12px;">
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="?r=transaction/index" class="btn" style="background: #e5e7eb;">Отмена</a>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
