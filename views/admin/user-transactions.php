<?php
$this->title = 'Операции: ' . $user->username;
?>

<div style="margin-bottom: 30px;">
    <a href="?r=admin/users" class="btn" style="background:#e5e7eb; margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Назад к сотрудникам
    </a>
    
    <div class="stats-grid">
        <div class="stat-card balance">
            <div class="stat-icon"><i class="fas fa-wallet"></i></div>
            <h3>Баланс <?= $user->username ?></h3>
            <div class="stat-value"><?= number_format($balance, 2) ?> ₽</div>
        </div>
        <div class="stat-card income">
            <div class="stat-icon"><i class="fas fa-arrow-up"></i></div>
            <h3>Доходы</h3>
            <div class="stat-value">+ <?= number_format($totalIncome, 2) ?> ₽</div>
        </div>
        <div class="stat-card expense">
            <div class="stat-icon"><i class="fas fa-arrow-down"></i></div>
            <h3>Расходы</h3>
            <div class="stat-value">- <?= number_format($totalExpense, 2) ?> ₽</div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Категория</th>
                    <th>Описание</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?= $t->transaction_date ?></td>
                    <td><span class="<?= $t->type == 'income' ? 'badge-income' : 'badge-expense' ?>"><?= $t->type == 'income' ? 'Доход' : 'Расход' ?></span></td>
                    <td><?= $t->category ? $t->category->name : '-' ?></td>
                    <td><?= $t->description ?: '-' ?></td>
                    <td class="<?= $t->type == 'income' ? 'income-text' : 'expense-text' ?>">
                        <?= $t->type == 'income' ? '+' : '-' ?> <?= number_format($t->amount, 2) ?> ₽
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
