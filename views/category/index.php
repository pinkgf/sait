<h2>📁 Управление категориями</h2>
<a href="?r=category/add" class="btn btn-primary">+ Добавить категорию</a>
<br><br>
<table class="table">
    <thead>
        <tr><th>ID</th><th>Название</th><th>Тип</th><th></th></tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $c): ?>
    <tr>
        <td><?= $c->id ?></td>
        <td><?= $c->name ?></td>
        <td><?= $c->type == 'income' ? '💰 Доход' : '💸 Расход' ?></td>
        <td><a href="?r=category/delete&id=<?= $c->id ?>" onclick="return confirm('Удалить?')" style="color:red">Удалить</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
