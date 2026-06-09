<?php
$this->title = 'Все операции';
$currentUser = $user;
?>

<div class="stats-grid">
    <div class="stat-card balance">
        <div class="stat-icon"><i class="fas fa-wallet"></i></div>
        <h3>Текущий баланс</h3>
        <div class="stat-value"><?= number_format($balance, 2) ?> ₽</div>
    </div>
    <div class="stat-card income">
        <div class="stat-icon"><i class="fas fa-arrow-up"></i></div>
        <h3>Всего доходов</h3>
        <div class="stat-value">+ <?= number_format($totalIncome, 2) ?> ₽</div>
    </div>
    <div class="stat-card expense">
        <div class="stat-icon"><i class="fas fa-arrow-down"></i></div>
        <h3>Всего расходов</h3>
        <div class="stat-value">- <?= number_format($totalExpense, 2) ?> ₽</div>
    </div>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
    <a href="?r=transaction/add" class="btn btn-success"><i class="fas fa-plus"></i> Добавить операцию</a>
    
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <span style="color: #6b7280;">Сортировка:</span>
        <a href="?r=transaction/index&sort=date_desc" class="btn" style="padding: 5px 12px; <?= $currentSort == 'date_desc' ? 'background:#4361ee; color:white;' : 'background:#e2e8f0;' ?>">📅 Новые</a>
        <a href="?r=transaction/index&sort=date_asc" class="btn" style="padding: 5px 12px; <?= $currentSort == 'date_asc' ? 'background:#4361ee; color:white;' : 'background:#e2e8f0;' ?>">📅 Старые</a>
        <a href="?r=transaction/index&sort=amount_desc" class="btn" style="padding: 5px 12px; <?= $currentSort == 'amount_desc' ? 'background:#4361ee; color:white;' : 'background:#e2e8f0;' ?>">💰 По сумме ↓</a>
        <a href="?r=transaction/index&sort=amount_asc" class="btn" style="padding: 5px 12px; <?= $currentSort == 'amount_asc' ? 'background:#4361ee; color:white;' : 'background:#e2e8f0;' ?>">💰 По сумме ↑</a>
    </div>
</div>

<div class="panel">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Кто добавил</th>
                    <th>Тип</th>
                    <th>Категория</th>
                    <th>Описание</th>
                    <th>Сумма</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transactions)): ?>
                <tr><td colspan="7" style="text-align: center; padding: 40px;">Нет операций</td></tr>
                <?php else: ?>
                    <?php foreach ($transactions as $t): ?>
                    <?php $isOwner = ($t->created_by == $currentUser->id); ?>
                    <tr>
                        <td><?= date('d.m.Y', strtotime($t->transaction_date)) ?></td>
                        <td><?= $t->creator ? $t->creator->username : '-' ?></td>
                        <td><span class="<?= $t->type == 'income' ? 'badge-income' : 'badge-expense' ?>"><?= $t->type == 'income' ? 'Доход' : 'Расход' ?></span></td>
                        <td><?= $t->category ? $t->category->name : '-' ?></td>
                        <td><?= $t->description ?: '-' ?></td>
                        <td class="<?= $t->type == 'income' ? 'income-text' : 'expense-text' ?>"><?= number_format($t->amount, 2) ?> ₽</td>
                        <td>
                            <?php if ($isOwner || $currentUser->isAdmin()): ?>
                                <a href="?r=transaction/edit&id=<?= $t->id ?>" style="color: #f59e0b; margin-right: 8px;"><i class="fas fa-edit"></i></a>
                                <a href="?r=transaction/delete&id=<?= $t->id ?>" onclick="return confirm('Удалить?')" style="color:#ef4444;"><i class="fas fa-trash"></i></a>
                            <?php else: ?>
                                <span style="color:#9ca3af;"><i class="fas fa-lock"></i></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
