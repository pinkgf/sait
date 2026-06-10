<?php
$this->title = 'Категории';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>📁 Категории</h1>
    <a href="/index.php?r=category/add" class="btn btn-success">+ Добавить категорию</a>
</div>

<table class="table table-striped">
    <thead><tr><th>ID</th><th>Название</th><th>Тип</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($categories as $cat): ?>
    <tr>
        <td><?= $cat->id ?></td>
        <td><?= $cat->name ?></td>
        <td><?= $cat->type == 'income' ? '💰 Доход' : '💸 Расход' ?></td>
        <td><a href="/index.php?r=category/delete&id=<?= $cat->id ?>" onclick="return confirm('Удалить?')">🗑️</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
