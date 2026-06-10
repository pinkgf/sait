<?php
use app\models\Category;
$this->title = "Отчет за {$monthName}";
?>

<div class="mb-4">
    <h1><i class="fas fa-chart-line"></i> Финансовый отчет</h1>
</div>

<!-- Выбор месяца -->
<div class="panel mb-4">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <label class="fw-bold"><i class="fas fa-calendar-alt"></i> Выберите месяц:</label>
        <form method="get" class="d-flex gap-2">
            <input type="hidden" name="r" value="report/index">
            <select name="month" class="form-select" style="width: auto;">
                <?php foreach ($monthsWithData as $m): ?>
                <option value="<?= $m['month'] ?>" <?= $selectedMonth == $m['month'] ? 'selected' : '' ?>>
                    <?= $m['month_name'] ?>
                </option>
                <?php endforeach; ?>
                <?php if (empty($monthsWithData)): ?>
                <option value="<?= date('Y-m') ?>"><?= date('F Y') ?></option>
                <?php endif; ?>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Показать</button>
        </form>
    </div>
</div>

<?php if (empty($transactions)): ?>
<div class="panel text-center p-5">
    <i class="fas fa-folder-open" style="font-size: 64px; color: #adb5bd;"></i>
    <h3 class="mt-3">Нет операций</h3>
    <p class="text-muted">За выбранный месяц нет операций</p>
    <a href="/index.php?r=transaction/add" class="btn btn-success mt-2">➕ Добавить операцию</a>
</div>
<?php else: ?>

<!-- Статистика -->
<div class="stats-grid mb-4">
    <div class="stat-card balance">
        <div class="stat-icon"><i class="fas fa-wallet"></i></div>
        <h3>Баланс за месяц</h3>
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

<!-- Доходы и расходы по категориям -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-header">
                <h3><i class="fas fa-chart-pie" style="color: #10b981;"></i> Доходы по категориям</h3>
                <span class="badge-income">Всего: <?= number_format($totalIncome, 2) ?> ₽</span>
            </div>
            <?php if (empty($incomeByCategory)): ?>
                <p class="text-center text-muted py-3">Нет данных</p>
            <?php else: ?>
                <?php foreach ($incomeByCategory as $item): ?>
                <?php $cat = Category::findOne($item['category_id']); ?>
                <?php $percent = $totalIncome > 0 ? round(($item['total'] / $totalIncome) * 100) : 0; ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span><?= $cat ? $cat->name : '-' ?></span>
                        <span class="income-text"><?= number_format($item['total'], 2) ?> ₽ (<?= $percent ?>%)</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: <?= $percent ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-header">
                <h3><i class="fas fa-chart-pie" style="color: #dc3545;"></i> Расходы по категориям</h3>
                <span class="badge-expense">Всего: <?= number_format($totalExpense, 2) ?> ₽</span>
            </div>
            <?php if (empty($expenseByCategory)): ?>
                <p class="text-center text-muted py-3">Нет данных</p>
            <?php else: ?>
                <?php foreach ($expenseByCategory as $item): ?>
                <?php $cat = Category::findOne($item['category_id']); ?>
                <?php $percent = $totalExpense > 0 ? round(($item['total'] / $totalExpense) * 100) : 0; ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span><?= $cat ? $cat->name : '-' ?></span>
                        <span class="expense-text"><?= number_format($item['total'], 2) ?> ₽ (<?= $percent ?>%)</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: <?= $percent ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Ежедневная динамика -->
<div class="panel mb-4">
    <div class="panel-header">
        <h3><i class="fas fa-calendar-day"></i> Ежедневная динамика</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr><th>День</th><th>Доходы</th><th>Расходы</th><th>Баланс дня</th></tr>
            </thead>
            <tbody>
                <?php foreach ($dailyData as $day): ?>
                <tr>
                    <td><?= $day['day'] ?> число</td>
                    <td class="income-text">+ <?= number_format($day['income'], 2) ?> ₽</td>
                    <td class="expense-text">- <?= number_format($day['expense'], 2) ?> ₽</td>
                    <td class="<?= ($day['income'] - $day['expense']) >= 0 ? 'income-text' : 'expense-text' ?>">
                        <?= number_format($day['income'] - $day['expense'], 2) ?> ₽
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Все операции за месяц -->
<div class="panel">
    <div class="panel-header">
        <h3><i class="fas fa-list"></i> Операции за месяц</h3>
        <span class="badge bg-secondary">Всего: <?= count($transactions) ?> операций</span>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>Дата</th><th>Кто</th><th>Тип</th><th>Категория</th><th>Описание</th><th>Сумма</th></tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?= date('d.m.Y', strtotime($t->transaction_date)) ?></td>
                    <td><?= $t->creator ? $t->creator->username : '-' ?></td>
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

<?php endif; ?>

<style>
.progress { height: 8px; border-radius: 4px; background: #e9ecef; }
.table-sm th, .table-sm td { padding: 8px; }
</style>
