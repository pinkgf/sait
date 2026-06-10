<?php
$this->title = 'Сменить пароль';
?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3>🔑 Смена пароля</h3></div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                    
                    <div class="mb-3">
                        <label>Новый пароль</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Подтверждение пароля</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Изменить пароль</button>
                    <a href="/index.php?r=profile/index" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</div>
