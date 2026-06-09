<?php
use yii\helpers\Html;
$this->title = 'Все операции';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
    <h1 style="font-size: 28px; font-weight: 700; color: #1f2937;"><i class="fas fa-list"></i> Все операции</h1>
    <a href="?r=cash/add" class="btn btn-success"><i class="fas fa-plus"></i> Добавить операцию</a>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 32px;">
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
    <div class="stat-card balance">
        <div class="stat-icon"><i class="fas fa-calculator"></i></div>
        <h3>Баланс</h3>
        <div class="stat-value"><?= number_format($balance, 2) ?> ₽</div>
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
                    <th style="width: 50px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transactions)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 60px; color: #6b7280;">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                        Нет операций. Добавьте первую!
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($transactions as $t): ?>
                    <tr>
                        <td><?= $t->transaction_date ?></td>
                        <td><span class="<?= $t->type == 'income' ? 'badge-income' : 'badge-expense' ?>"><?= $t->type == 'income' ? 'Доход' : 'Расход' ?></span></td>
                        <td><?= $t->category ? $t->category->name : '-' ?></td>
                        <td><?= $t->description ?: '-' ?></td>
                        <td class="<?= $t->type == 'income' ? 'income-text' : 'expense-text' ?>" style="font-weight: 700;">
                            <?= $t->type == 'income' ? '+' : '-' ?> <?= number_format($t->amount, 2) ?> ₽
                        </td>
                        <td>
                            <a href="?r=cash/delete&id=<?= $t->id ?>" onclick="return confirm('Удалить операцию?')" style="color: #ef4444; text-decoration: none;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
