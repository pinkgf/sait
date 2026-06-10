<h1>Добавить сотрудника</h1>
<form method="post">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <div class="mb-3"><label>Логин</label><input type="text" name="username" class="form-control" required></div>
    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
    <div class="mb-3"><label>Полное имя</label><input type="text" name="full_name" class="form-control"></div>
    <div class="mb-3"><label>Роль</label><select name="role" class="form-control"><option value="employee">Сотрудник</option><option value="admin">Администратор</option></select></div>
    <div class="mb-3"><label>Права</label><select name="permission" class="form-control"><option value="both">Все</option><option value="income_only">Только доходы</option><option value="expense_only">Только расходы</option></select></div>
    <div class="mb-3"><label>Пароль</label><input type="password" name="password" class="form-control" required></div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
    <a href="/index.php?r=admin/users" class="btn btn-secondary">Отмена</a>
</form>
