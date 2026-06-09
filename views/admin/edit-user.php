<?php
$this->title = 'Редактировать сотрудника';
?>

<div class="form-card" style="max-width: 500px;">
    <h2 style="margin-bottom: 24px;"><i class="fas fa-user-edit"></i> Редактирование</h2>
    
    <form method="post">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        
        <div class="form-group">
            <label>Логин</label>
            <input type="text" value="<?= $user->username ?>" disabled style="background:#f0f0f0;">
        </div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= $user->email ?>" required>
        </div>
        
        <div class="form-group">
            <label>Полное имя</label>
            <input type="text" name="full_name" value="<?= $user->full_name ?>" required>
        </div>
        
        <div class="form-group">
            <label>Роль</label>
            <select name="role">
                <option value="employee" <?= $user->role == 'employee' ? 'selected' : '' ?>>👤 Сотрудник</option>
                <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>👑 Администратор</option>
            </select>
        </div>
        
        <?php if ($user->role != 'admin'): ?>
        <div class="form-group">
            <label>Права доступа</label>
            <select name="permission">
                <option value="both" <?= $user->permission == 'both' ? 'selected' : '' ?>>💰 Все операции</option>
                <option value="income_only" <?= $user->permission == 'income_only' ? 'selected' : '' ?>>📈 Только доходы</option>
                <option value="expense_only" <?= $user->permission == 'expense_only' ? 'selected' : '' ?>>📉 Только расходы</option>
            </select>
            <div style="font-size: 12px; color: #64748b; margin-top: 5px;">
                <i class="fas fa-info-circle"></i> 
                "Только доходы" - сотрудник может добавлять/редактировать только доходы.<br>
                "Только расходы" - сотрудник может добавлять/редактировать только расходы.
            </div>
        </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label>Новый пароль (оставьте пустым, если не менять)</label>
            <input type="password" name="password" placeholder="Введите новый пароль">
        </div>
        
        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="?r=admin/users" class="btn" style="background:#e5e7eb;">Отмена</a>
        </div>
    </form>
</div>
