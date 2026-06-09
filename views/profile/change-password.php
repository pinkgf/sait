<?php
$this->title = 'Смена пароля';
?>

<div style="max-width: 600px; margin: 0 auto;">
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-key" style="color: #6366f1;"></i> Смена пароля</h3>
        </div>
        <div style="padding: 30px;">
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div style="background: #fee2e2; color: #ef4444; padding: 12px; border-radius: 12px; margin-bottom: 20px;">
                    <i class="fas fa-exclamation-triangle"></i> <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Новый пароль</label>
                    <input type="password" name="new_password" required placeholder="Введите новый пароль">
                    <div style="font-size: 12px; color: #6b7280; margin-top: 5px;">Минимум 6 символов</div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-check-circle"></i> Подтверждение пароля</label>
                    <input type="password" name="confirm_password" required placeholder="Повторите пароль">
                </div>
                
                <div style="display: flex; gap: 12px; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Изменить пароль
                    </button>
                    <a href="?r=profile/index" class="btn" style="background: #e5e7eb; color: #374151;">
                        <i class="fas fa-times"></i> Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
