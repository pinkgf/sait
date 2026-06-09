<?php
$this->title = 'Управление сотрудниками';

$totalIncomeAll = 0;
$totalExpenseAll = 0;
foreach ($stats as $s) {
    $totalIncomeAll += $s['totalIncome'];
    $totalExpenseAll += $s['totalExpense'];
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1><i class="fas fa-users"></i> Сотрудники</h1>
    <a href="?r=admin/add-user" class="btn btn-primary"><i class="fas fa-plus"></i> Добавить сотрудника</a>
</div>

<div class="stats-grid" style="margin-bottom: 30px;">
    <div class="stat-card balance">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <h3>Всего сотрудников</h3>
        <div class="stat-value"><?= count($users) ?></div>
    </div>
    <div class="stat-card income">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <h3>Общие доходы</h3>
        <div class="stat-value">+ <?= number_format($totalIncomeAll, 2) ?> ₽</div>
    </div>
    <div class="stat-card expense">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <h3>Общие расходы</h3>
        <div class="stat-value">- <?= number_format($totalExpenseAll, 2) ?> ₽</div>
    </div>
</div>

<div class="panel">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Роль</th>
                    <th>Баланс</th>
                    <th>Операций</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <?php $userStats = $stats[$u->id] ?? ['totalIncome' => 0, 'totalExpense' => 0, 'balance' => 0, 'operationsCount' => 0]; ?>
                <tr>
                    <td>#<?= $u->id ?></td>
                    <td>
                        <strong><?= $u->username ?></strong><br>
                        <small style="color:#6b7280"><?= $u->email ?></small>
                    </td>
                    <td><?= $u->getRoleLabel() ?></td>
                    <td class="<?= $userStats['balance'] >= 0 ? 'income-text' : 'expense-text' ?>">
                        <?= number_format($userStats['balance'], 2) ?> ₽
                    </td>
                    <td><?= $userStats['operationsCount'] ?></td>
                    <td><?= date('d.m.Y', $u->created_at) ?></td>
                    <td>
                        <a href="?r=admin/user-transactions&id=<?= $u->id ?>" style="color:#3b82f6; margin-right:10px;">
                            <i class="fas fa-list"></i>
                        </a>
                        <?php if ($u->id != Yii::$app->user->id): ?>
                            <a href="?r=admin/edit-user&id=<?= $u->id ?>" style="color:#f59e0b; margin-right:10px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="?r=admin/delete-user&id=<?= $u->id ?>" onclick="return confirm('Удалить сотрудника?')" style="color:#ef4444;">
                                <i class="fas fa-trash"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
