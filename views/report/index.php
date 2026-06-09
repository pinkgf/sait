<?php
use app\models\Category;
$this->title = "Отчет за {$monthName}";
?>

<!-- Красивая шапка отчета -->
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 32px; margin-bottom: 28px; color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;"><i class="fas fa-chart-line"></i> Финансовый отчет</h1>
            <p style="opacity: 0.9; margin: 0;">Полная аналитика за выбранный период</p>
        </div>
        <div style="background: rgba(255,255,255,0.15); border-radius: 16px; padding: 16px 24px; backdrop-filter: blur(10px);">
            <div style="font-size: 13px; opacity: 0.8;">Период</div>
            <div style="font-size: 20px; font-weight: 700;"><?= $monthName ?></div>
        </div>
    </div>
</div>

<!-- Выбор месяца - только с данными -->
<div style="background: white; border-radius: 20px; padding: 20px 24px; margin-bottom: 28px; border: 1px solid #e2e8f0;">
    <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="background: #eef2ff; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-alt" style="color: #4361ee; font-size: 18px;"></i>
            </div>
            <div>
                <div style="font-size: 12px; color: #64748b;">Выберите месяц</div>
                <div style="font-weight: 600; font-size: 14px;">С операциями</div>
            </div>
        </div>
        <form method="get" style="display: flex; gap: 12px; align-items: center; flex: 1; flex-wrap: wrap;">
            <input type="hidden" name="r" value="report/index">
            <select name="month" style="padding: 10px 16px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; background: white; min-width: 180px;">
                <?php foreach ($months as $value => $label): ?>
                <option value="<?= $value ?>" <?= $currentMonth == $value ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" style="background: #4361ee; color: white; border: none; padding: 10px 24px; border-radius: 12px; font-weight: 500; cursor: pointer;">
                <i class="fas fa-chart-simple"></i> Показать отчет
            </button>
        </form>
    </div>
</div>

<?php if (!$hasData): ?>
<!-- Нет данных за выбранный месяц -->
<div style="background: white; border-radius: 20px; padding: 48px; text-align: center; border: 1px solid #e2e8f0;">
    <i class="fas fa-folder-open" style="font-size: 64px; color: #cbd5e1; margin-bottom: 16px; display: block;"></i>
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">Нет операций</h3>
    <p style="color: #64748b; margin-bottom: 24px;">За выбранный период нет ни одной операции</p>
    <a href="?r=transaction/add" class="btn btn-primary">+ Добавить операцию</a>
</div>
<?php else: ?>

<!-- Карточки статистики -->
<div class="stats-grid" style="margin-bottom: 28px;">
    <div class="stat-card balance" style="border-left: 4px solid #3b82f6;">
        <div class="stat-icon"><i class="fas fa-wallet"></i></div>
        <h3>Баланс за месяц</h3>
        <div class="stat-value"><?= number_format($balance, 2) ?> ₽</div>
    </div>
    <div class="stat-card income" style="border-left: 4px solid #10b981;">
        <div class="stat-icon"><i class="fas fa-arrow-up"></i></div>
        <h3>Доходы</h3>
        <div class="stat-value">+ <?= number_format($totalIncome, 2) ?> ₽</div>
    </div>
    <div class="stat-card expense" style="border-left: 4px solid #ef4444;">
        <div class="stat-icon"><i class="fas fa-arrow-down"></i></div>
        <h3>Расходы</h3>
        <div class="stat-value">- <?= number_format($totalExpense, 2) ?> ₽</div>
    </div>
</div>

<!-- Доходы и расходы по категориям -->
<div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px;">
    <!-- Доходы -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-chart-pie" style="color: #10b981;"></i> Доходы по категориям</h3>
            <span style="background: #ecfdf5; color: #10b981; padding: 4px 12px; border-radius: 30px; font-size: 13px;">Всего: <?= number_format($totalIncome, 2) ?> ₽</span>
        </div>
        <div>
            <?php if (empty($incomeByCategory)): ?>
                <p style="text-align:center; color:#64748b; padding: 40px;">Нет данных</p>
            <?php else: ?>
                <?php foreach ($incomeByCategory as $item): ?>
                <?php $cat = Category::findOne($item['category_id']); ?>
                <?php $percent = $totalIncome > 0 ? ($item['total'] / $totalIncome) * 100 : 0; ?>
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                        <span><i class="fas fa-tag" style="color: #10b981;"></i> <?= $cat ? $cat->name : '-' ?></span>
                        <span style="font-weight: 600; color: #10b981;"><?= number_format($item['total'], 2) ?> ₽ (<?= round($percent) ?>%)</span>
                    </div>
                    <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                        <div style="height: 100%; width: <?= $percent ?>%; background: linear-gradient(90deg, #10b981, #34d399);"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Расходы -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-chart-pie" style="color: #ef4444;"></i> Расходы по категориям</h3>
            <span style="background: #fef2f2; color: #ef4444; padding: 4px 12px; border-radius: 30px; font-size: 13px;">Всего: <?= number_format($totalExpense, 2) ?> ₽</span>
        </div>
        <div>
            <?php if (empty($expenseByCategory)): ?>
                <p style="text-align:center; color:#64748b; padding: 40px;">Нет данных</p>
            <?php else: ?>
                <?php foreach ($expenseByCategory as $item): ?>
                <?php $cat = Category::findOne($item['category_id']); ?>
                <?php $percent = $totalExpense > 0 ? ($item['total'] / $totalExpense) * 100 : 0; ?>
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                        <span><i class="fas fa-tag" style="color: #ef4444;"></i> <?= $cat ? $cat->name : '-' ?></span>
                        <span style="font-weight: 600; color: #ef4444;"><?= number_format($item['total'], 2) ?> ₽ (<?= round($percent) ?>%)</span>
                    </div>
                    <div style="height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                        <div style="height: 100%; width: <?= $percent ?>%; background: linear-gradient(90deg, #ef4444, #f87171);"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Ежедневная динамика -->
<div class="panel" style="margin-bottom: 28px;">
    <div class="panel-header">
        <h3><i class="fas fa-calendar-day"></i> Ежедневная динамика</h3>
    </div>
    <div class="table-container">
        <table class="table">
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
        <h3><i class="fas fa-list"></i> Все операции за месяц</h3>
        <span style="background: #f1f5f9; color: #475569; padding: 4px 12px; border-radius: 30px; font-size: 13px;">Всего: <?= count($transactions) ?> операций</span>
    </div>
    <div class="table-container">
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
