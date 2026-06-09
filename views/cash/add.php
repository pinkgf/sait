<?php
$this->title = 'Добавить операцию';
?>

<div class="form-card">
    <h2 style="margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-plus-circle" style="color: #6366f1;"></i> Новая операция
    </h2>
    
    <form method="post">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        
        <div class="form-group">
            <label><i class="fas fa-tag"></i> Тип операции</label>
            <select name="type" required>
                <option value="">Выберите тип</option>
                <option value="income">💰 Доход</option>
                <option value="expense">💸 Расход</option>
            </select>
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-folder"></i> Категория</label>
            <select name="category_id" required>
                <option value="">Выберите категорию</option>
                <?php foreach ($categories as $c): ?>
                <option value="<?= $c->id ?>"><?= $c->name ?> (<?= $c->type == 'income' ? 'Доход' : 'Расход' ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-ruble-sign"></i> Сумма</label>
            <input type="number" step="0.01" name="amount" placeholder="0.00" required>
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-calendar"></i> Дата</label>
            <input type="date" name="transaction_date" value="<?= date('Y-m-d') ?>" required>
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-align-left"></i> Описание</label>
            <textarea name="description" rows="3" placeholder="Дополнительная информация..."></textarea>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Сохранить</button>
            <a href="?r=cash/index" class="btn" style="background: #e5e7eb; color: #374151;"><i class="fas fa-times"></i> Отмена</a>
        </div>
    </form>
</div>
