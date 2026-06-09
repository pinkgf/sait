<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KassaPro - Учет кассы</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            color: #1e293b;
        }
        
        /* Шапка */
        .header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 64px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            text-decoration: none;
        }
        
        .logo i {
            font-size: 24px;
            color: #3b82f6;
        }
        
        .nav {
            display: flex;
            gap: 6px;
        }
        
        .nav a {
            padding: 8px 16px;
            color: #64748b;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .nav a i {
            font-size: 15px;
        }
        
        .nav a:hover {
            background: #f1f5f9;
            color: #3b82f6;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: #f1f5f9;
            border-radius: 30px;
        }
        
        .user-info i {
            font-size: 14px;
            color: #3b82f6;
        }
        
        .user-info span {
            font-size: 13px;
            font-weight: 500;
            color: #1e293b;
        }
        
        .logout-btn {
            background: #ef4444;
            color: white;
            padding: 6px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }
        
        .logout-btn:hover {
            background: #dc2626;
        }
        
        /* Контейнер */
        .container {
            max-width: 1280px;
            margin: 28px auto;
            padding: 0 24px;
        }
        
        /* Карточки статистики */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }
        
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            transition: all 0.2s;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        }
        
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }
        
        .stat-icon i { font-size: 22px; }
        
        .balance .stat-icon { background: #eff6ff; color: #3b82f6; }
        .income .stat-icon { background: #ecfdf5; color: #10b981; }
        .expense .stat-icon { background: #fef2f2; color: #ef4444; }
        .profit .stat-icon { background: #fff7ed; color: #f59e0b; }
        
        .stat-card h3 {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 6px;
            font-weight: 500;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
        }
        
        /* Панели */
        .panel {
            background: white;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .panel-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Таблица */
        .table-container {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th {
            text-align: left;
            padding: 12px 8px;
            color: #64748b;
            font-weight: 500;
            font-size: 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table td {
            padding: 12px 8px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        
        /* Кнопки */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        .badge-income {
            background: #ecfdf5;
            color: #10b981;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-expense {
            background: #fef2f2;
            color: #ef4444;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .income-text { color: #10b981; font-weight: 600; }
        .expense-text { color: #ef4444; font-weight: 600; }
        
        /* Формы */
        .form-card {
            max-width: 540px;
            background: white;
            border-radius: 24px;
            padding: 32px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1e293b;
            font-size: 13px;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            font-size: 14px;
            background: white;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }
        
        /* Алерты */
        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 24px;
        }
        
        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border-left: 3px solid #10b981;
        }
        
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border-left: 3px solid #ef4444;
        }
        
        /* Профиль */
        .profile-header {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 28px;
            color: white;
            text-align: center;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        
        .profile-avatar i {
            font-size: 40px;
        }
        
        /* Адаптив */
        @media (max-width: 1000px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 768px) {
            .header-container { flex-direction: column; height: auto; padding: 16px; gap: 12px; }
            .nav { flex-wrap: wrap; justify-content: center; }
            .stats-grid { grid-template-columns: 1fr; }
            .stat-value { font-size: 24px; }
            .container { padding: 0 16px; }
        }
    </style>
    <?php $this->head() ?>
</head>
<body>

<div class="header">
    <div class="header-container">
        <a href="?r=site/index" class="logo">
            <i class="fas fa-coins"></i>
            <span>KassaPro</span>
        </a>
        
        <?php if (!Yii::$app->user->isGuest): ?>
        <div class="nav">
            <a href="?r=site/index"><i class="fas fa-chart-pie"></i> Главная</a>
            <a href="?r=transaction/index"><i class="fas fa-list-ul"></i> Операции</a>
            <a href="?r=report/index"><i class="fas fa-chart-line"></i> Отчеты</a>
            <a href="?r=transaction/add"><i class="fas fa-plus"></i> Добавить</a>
            <a href="?r=category/index"><i class="fas fa-tags"></i> Категории</a>
            <a href="?r=profile/index"><i class="fas fa-user"></i> Профиль</a>
            <?php if (Yii::$app->user->identity->role == 'admin'): ?>
            <a href="?r=admin/users"><i class="fas fa-users"></i> Сотрудники</a>
            <a href="?r=log/index"><i class="fas fa-history"></i> Логи</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="user-menu">
            <?php if (!Yii::$app->user->isGuest): ?>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span><?= Yii::$app->user->identity->username ?></span>
                </div>
                <a href="?r=site/logout" class="logout-btn" data-method="post">
                    <i class="fas fa-sign-out-alt"></i> Выйти
                </a>
            <?php else: ?>
                <a href="?r=site/login" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Войти</a>
                <a href="?r=site/register" class="btn" style="background: #f1f5f9; color: #1e293b;"><i class="fas fa-user-plus"></i> Регистрация</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
