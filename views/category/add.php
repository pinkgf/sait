<h2>➕ Новая категория</h2>
<form method="post">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <div class="form-group">
        <label>Название</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Тип</label>
        <select name="type">
            <option value="income">Доход</option>
            <option value="expense">Расход</option>
        </select>
    </div>
    <button type="submit">Сохранить</button>
    <a href="?r=category/index">Отмена</a>
</form>
