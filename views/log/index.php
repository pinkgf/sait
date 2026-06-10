<?php
$this->title = 'Журнал действий';
?>

<h1>📜 Журнал действий</h1>
<table class="table table-striped">
    <thead><tr><th>Пользователь</th><th>Действие</th><th>Описание</th><th>IP</th><th>Время</th></tr></thead>
    <tbody>
    <?php foreach ($logs as $log): ?>
    <tr>
        <td><?= $log->user ? $log->user->username : '-' ?></td>
        <td><?= $log->action ?></td>
        <td><?= $log->description ?></td>
        <td><?= $log->ip ?></td>
        <td><?= date('d.m.Y H:i:s', $log->created_at) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
