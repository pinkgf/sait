<?php
$this->title = 'Редактировать профиль';
?>

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-user-edit" style="color: #6366f1;"></i> Редактирование профиля</h3>
        </div>
        <div style="padding: 30px;">
            <form method="post">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Логин</label>
                    <input type="text" value="<?= $user->username ?>" disabled style="background:#f0f0f0;">
                    <div style="font-size: 12px; color: #6b7280; margin-top: 5px;">Логин нельзя изменить</div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> Полное имя</label>
                    <input type="text" name="full_name" value="<?= $user->full_name ?>" placeholder="Введите ваше полное имя" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" value="<?= $user->email ?>" placeholder="example@mail.com" required>
                </div>
                
                <div style="display: flex; gap: 12px; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Сохранить изменения
                    </button>
                    <a href="?r=profile/index" class="btn" style="background: #e5e7eb; color: #374151;">
                        <i class="fas fa-times"></i> Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
