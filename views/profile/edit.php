<?php
$this->title = 'Редактировать профиль';
?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3>✏️ Редактирование профиля</h3></div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                    
                    <div class="mb-3">
                        <label>Логин</label>
                        <input type="text" value="<?= $user->username ?>" class="form-control" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= $user->email ?>" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Полное имя</label>
                        <input type="text" name="full_name" value="<?= $user->full_name ?>" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a href="/index.php?r=profile/index" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</div>
