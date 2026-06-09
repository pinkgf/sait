<?php
use app\models\Transaction;
use app\models\CashBalance;

$totalIncome = Transaction::find()->where(['type' => 'income'])->sum('amount') ?: 0;
$totalExpense = Transaction::find()->where(['type' => 'expense'])->sum('amount') ?: 0;
$balance = $totalIncome - $totalExpense;
$recent = Transaction::find()->with('category', 'creator')->orderBy(['created_at' => SORT_DESC])->limit(10)->all();
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
    <div class="stat-card profit">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <h3>Чистая прибыль</h3>
        <div class="stat-value"><?= number_format($balance, 2) ?> ₽</div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3><i class="fas fa-clock"></i> Последние операции</h3>
        <a href="?r=transaction/index" style="color: #3b82f6; text-decoration: none; font-size: 13px;">Все операции →</a>
    </div>
    
    <?php if (empty($recent)): ?>
        <div style="text-align: center; padding: 48px; color: #64748b;">
            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; display: block; color: #cbd5e1;"></i>
            <p>Нет операций</p>
            <a href="?r=transaction/add" style="color: #3b82f6; text-decoration: none; margin-top: 12px; display: inline-block;">+ Добавить первую операцию</a>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Тип</th>
                        <th>Категория</th>
                        <th>Описание</th>
                        <th>Сумма</th>
                        <th>Кто</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent as $t): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td><?= date('d.m.Y', strtotime($t->transaction_date)) ?></td>
                        <td><span class="<?= $t->type == 'income' ? 'badge-income' : 'badge-expense' ?>"><?= $t->type == 'income' ? 'Доход' : 'Расход' ?></span></td>
                        <td><?= $t->category ? $t->category->name : '-' ?></td>
                        <td><?= $t->description ?: '-' ?></td>
                        <td class="<?= $t->type == 'income' ? 'income-text' : 'expense-text' ?>"><?= $t->type == 'income' ? '+' : '-' ?> <?= number_format($t->amount, 2) ?> ₽</td>
                        <td style="color: #64748b; font-size: 13px;"><?= $t->creator ? $t->creator->username : '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
