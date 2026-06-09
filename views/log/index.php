<?php
$this->title = 'Журнал действий';
?>

<div style="margin-bottom: 30px;">
    <h1><i class="fas fa-history"></i> Журнал действий</h1>
    <p style="color: #6b7280;">Все действия пользователей в системе</p>
</div>

<div class="panel">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Действие</th>
                    <th>Описание</th>
                    <th>IP адрес</th>
                    <th>Время</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                <tr><td colspan="6" style="text-align: center; padding: 60px;">Логов пока нет</td></tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td>#<?= $log->id ?></td>
                        <td>
                            <strong><?= $log->user ? $log->user->username : '-' ?></strong>
                        </td>
                        <td>
                            <?php
                            $icon = '';
                            if (strpos($log->action, 'Добавление') !== false) $icon = '<i class="fas fa-plus-circle" style="color:#10b981"></i>';
                            elseif (strpos($log->action, 'Редактирование') !== false) $icon = '<i class="fas fa-edit" style="color:#f59e0b"></i>';
                            elseif (strpos($log->action, 'Удаление') !== false) $icon = '<i class="fas fa-trash" style="color:#ef4444"></i>';
                            else $icon = '<i class="fas fa-info-circle" style="color:#3b82f6"></i>';
                            echo $icon . ' ' . $log->action;
                            ?>
                         </td>
                        <td><?= $log->description ?: '-' ?></td>
                        <td><code><?= $log->ip ?></code></td>
                        <td><?= date('d.m.Y H:i:s', $log->created_at) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
