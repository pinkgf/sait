<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Добавить операцию';
$canIncome = $user->canAddIncome();
$canExpense = $user->canAddExpense();
?>

<div class="form-card">
    <h2 style="margin-bottom: 24px;"><i class="fas fa-plus-circle"></i> Добавить операцию</h2>
    
    <?php if (!$canIncome && !$canExpense): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> У вас нет прав на добавление операций. Обратитесь к администратору.
        </div>
    <?php else: ?>
        <?php $form = ActiveForm::begin(); ?>
        
        <div class="form-group">
            <label>Тип операции</label>
            <select name="Transaction[type]" id="type-select" class="form-control" required>
                <option value="">Выберите тип</option>
                <?php if ($canIncome): ?>
                <option value="income">💰 Доход</option>
                <?php endif; ?>
                <?php if ($canExpense): ?>
                <option value="expense">💸 Расход</option>
                <?php endif; ?>
            </select>
        </div>
        
        <div id="income-categories" style="display:none;">
            <div class="form-group">
                <label>Категория дохода</label>
                <select name="Transaction[category_id]" class="form-control">
                    <option value="">Выберите категорию</option>
                    <?php foreach ($incomeCategories as $cat): ?>
                    <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div id="expense-categories" style="display:none;">
            <div class="form-group">
                <label>Категория расхода</label>
                <select name="Transaction[category_id]" class="form-control">
                    <option value="">Выберите категорию</option>
                    <?php foreach ($expenseCategories as $cat): ?>
                    <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label>Сумма</label>
            <input type="number" step="0.01" name="Transaction[amount]" class="form-control" placeholder="0.00" required>
        </div>
        
        <div class="form-group">
            <label>Дата</label>
            <input type="date" name="Transaction[transaction_date]" value="<?= date('Y-m-d') ?>" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Описание</label>
            <textarea name="Transaction[description]" class="form-control" rows="3" placeholder="Дополнительная информация..."></textarea>
        </div>
        
        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="?r=transaction/index" class="btn" style="background: #e5e7eb;">Отмена</a>
        </div>
        
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>

<script>
document.getElementById('type-select')?.addEventListener('change', function() {
    var incomeDiv = document.getElementById('income-categories');
    var expenseDiv = document.getElementById('expense-categories');
    
    if (this.value == 'income') {
        incomeDiv.style.display = 'block';
        expenseDiv.style.display = 'none';
    } else if (this.value == 'expense') {
        incomeDiv.style.display = 'none';
        expenseDiv.style.display = 'block';
    } else {
        incomeDiv.style.display = 'none';
        expenseDiv.style.display = 'none';
    }
});
</script>
