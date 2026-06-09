<?php
$this->title = 'Добавить сотрудника';
?>

<div class="form-card" style="max-width: 500px;">
    <h2 style="margin-bottom: 24px;"><i class="fas fa-user-plus"></i> Новый сотрудник</h2>
    
    <form method="post">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        
        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="username" required>
        </div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label>Полное имя</label>
            <input type="text" name="full_name" required>
        </div>
        
        <div class="form-group">
            <label>Роль</label>
            <select name="role">
                <option value="user">👤 Сотрудник</option>
                <option value="manager">📋 Менеджер</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password" required>
        </div>
        
        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Добавить</button>
            <a href="?r=admin/users" class="btn" style="background:#e5e7eb;">Отмена</a>
        </div>
    </form>
</div>
