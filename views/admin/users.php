<?php
$this->title = 'Управление сотрудниками';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>👑 Управление сотрудниками</h1>
    <a href="/index.php?r=admin/add-user" class="btn btn-success">+ Добавить сотрудника</a>
</div>

<table class="table table-striped">
    <thead><tr><th>ID</th><th>Логин</th><th>Имя</th><th>Email</th><th>Роль</th><th>Права</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= $u->id ?></td>
        <td><?= $u->username ?></td>
        <td><?= $u->full_name ?></td>
        <td><?= $u->email ?></td>
        <td><?= $u->role == 'admin' ? 'Админ' : 'Сотрудник' ?></td>
        <td><?= $u->permission ?></td>
        <td>
            <a href="/index.php?r=admin/edit-user&id=<?= $u->id ?>">✏️</a>
            <a href="/index.php?r=admin/delete-user&id=<?= $u->id ?>" onclick="return confirm('Удалить?')">🗑️</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
