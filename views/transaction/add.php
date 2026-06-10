<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Добавить операцию';
$user = Yii::$app->user->identity;
$canIncome = $user->canAddIncome();
$canExpense = $user->canAddExpense();
?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3>➕ Добавить операцию</h3></div>
            <div class="card-body">
                <?php if (!$canIncome && !$canExpense): ?>
                    <div class="alert alert-danger">У вас нет прав на добавление операций</div>
                <?php else: ?>
                    <?php $form = ActiveForm::begin(); ?>
                    
                    <?php if ($canIncome && $canExpense): ?>
                        <?= $form->field($model, 'type')->dropDownList(['income' => 'Доход', 'expense' => 'Расход'], ['prompt' => 'Выберите тип']) ?>
                    <?php elseif ($canIncome): ?>
                        <?= Html::activeHiddenInput($model, 'type', ['value' => 'income']) ?>
                        <div class="alert alert-info">Доступно добавление только доходов</div>
                    <?php elseif ($canExpense): ?>
                        <?= Html::activeHiddenInput($model, 'type', ['value' => 'expense']) ?>
                        <div class="alert alert-info">Доступно добавление только расходов</div>
                    <?php endif; ?>
                    
                    <?php
                    $allCategories = array_merge($incomeCategories, $expenseCategories);
                    ?>
                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($allCategories, 'id', 'name'), ['prompt' => 'Выберите категорию']) ?>
                    
                    <?= $form->field($model, 'amount')->textInput(['type' => 'number', 'step' => '0.01']) ?>
                    
                    <?= $form->field($model, 'transaction_date')->input('date', ['value' => date('Y-m-d')]) ?>
                    
                    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
                    
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a href="/index.php?r=transaction/index" class="btn btn-secondary">Отмена</a>
                    
                    <?php ActiveForm::end(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
