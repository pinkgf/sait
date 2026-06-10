<?php
$this->title = 'Все операции';
$user = Yii::$app->user->identity;
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

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1><i class="fas fa-list"></i> Операции</h1>
    <div class="d-flex gap-2">
        <?php if ($user->canAddIncome() || $user->canAddExpense()): ?>
        <a href="/index.php?r=transaction/add" class="btn btn-success"><i class="fas fa-plus"></i> Добавить</a>
        <?php endif; ?>
    </div>
</div>

<!-- Панель сортировки -->
<div class="panel mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="fas fa-sort"></i> Сортировка:</span>
        <div class="d-flex gap-2 flex-wrap">
            <a href="/index.php?r=transaction/index&sort=date_desc" class="btn btn-sm <?= $currentSort == 'date_desc' ? 'btn-primary' : 'btn-outline-secondary' ?>">📅 Новые сначала</a>
            <a href="/index.php?r=transaction/index&sort=date_asc" class="btn btn-sm <?= $currentSort == 'date_asc' ? 'btn-primary' : 'btn-outline-secondary' ?>">📅 Старые сначала</a>
            <a href="/index.php?r=transaction/index&sort=amount_desc" class="btn btn-sm <?= $currentSort == 'amount_desc' ? 'btn-primary' : 'btn-outline-secondary' ?>">💰 По сумме ↓</a>
            <a href="/index.php?r=transaction/index&sort=amount_asc" class="btn btn-sm <?= $currentSort == 'amount_asc' ? 'btn-primary' : 'btn-outline-secondary' ?>">💰 По сумме ↑</a>
            <a href="/index.php?r=transaction/index&sort=type_income" class="btn btn-sm <?= $currentSort == 'type_income' ? 'btn-primary' : 'btn-outline-secondary' ?>">📈 Только доходы</a>
            <a href="/index.php?r=transaction/index&sort=type_expense" class="btn btn-sm <?= $currentSort == 'type_expense' ? 'btn-primary' : 'btn-outline-secondary' ?>">📉 Только расходы</a>
        </div>
    </div>
</div>

<div class="panel">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr><th>Дата</th><th>Кто добавил</th><th>Тип</th><th>Категория</th><th>Описание</th><th>Сумма</th><th></th></tr>
            </thead>
            <tbody>
            <?php foreach ($transactions as $t): ?>
            <?php $isOwner = ($t->created_by == $user->id); ?>
            <tr>
                <td><?= date('d.m.Y', strtotime($t->transaction_date)) ?></td>
                <td>
                    <?= $t->creator ? $t->creator->username : '-' ?>
                    <?php if ($isOwner): ?>
                        <span class="badge bg-info" style="font-size:10px">моя</span>
                    <?php endif; ?>
                </td>
                <td><span class="<?= $t->type == 'income' ? 'badge-income' : 'badge-expense' ?>"><?= $t->type == 'income' ? '💰 Доход' : '💸 Расход' ?></span></td>
                <td><?= $t->category ? $t->category->name : '-' ?></td>
                <td><?= $t->description ?: '-' ?></td>
                <td class="<?= $t->type == 'income' ? 'income-text' : 'expense-text' ?>"><?= number_format($t->amount, 2) ?> ₽</td>
                <td>
                    <?php if ($isOwner || $user->role === 'admin'): ?>
                        <a href="/index.php?r=transaction/edit&id=<?= $t->id ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <a href="/index.php?r=transaction/delete&id=<?= $t->id ?>" onclick="return confirm('Удалить?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                    <?php else: ?>
                        <span class="text-muted"><i class="fas fa-lock"></i></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.btn-outline-secondary { background: transparent; border: 1px solid #6c757d; color: #6c757d; }
.btn-outline-secondary:hover { background: #6c757d; color: white; }
.btn-sm { padding: 5px 12px; font-size: 12px; }
.gap-2 { gap: 8px; }
.flex-wrap { flex-wrap: wrap; }
</style>
