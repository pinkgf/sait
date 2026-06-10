<h1>Редактировать сотрудника</h1>
<form method="post">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <div class="mb-3"><label>Логин</label><input type="text" value="<?= $user->username ?>" class="form-control" disabled></div>
    <div class="mb-3"><label>Email</label><input type="email" name="email" value="<?= $user->email ?>" class="form-control" required></div>
    <div class="mb-3"><label>Полное имя</label><input type="text" name="full_name" value="<?= $user->full_name ?>" class="form-control"></div>
    <div class="mb-3"><label>Роль</label><select name="role" class="form-control"><option value="employee" <?= $user->role=='employee'?'selected':'' ?>>Сотрудник</option><option value="admin" <?= $user->role=='admin'?'selected':'' ?>>Администратор</option></select></div>
    <div class="mb-3"><label>Права</label><select name="permission" class="form-control"><option value="both" <?= $user->permission=='both'?'selected':'' ?>>Все</option><option value="income_only" <?= $user->permission=='income_only'?'selected':'' ?>>Только доходы</option><option value="expense_only" <?= $user->permission=='expense_only'?'selected':'' ?>>Только расходы</option></select></div>
    <div class="mb-3"><label>Новый пароль</label><input type="password" name="password" class="form-control" placeholder="Оставьте пустым"></div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
    <a href="/index.php?r=admin/users" class="btn btn-secondary">Отмена</a>
</form>
