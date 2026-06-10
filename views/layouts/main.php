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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
        .navbar { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; }
        .navbar-brand i { color: #f39c12; margin-right: 8px; }
        .nav-link { color: #e0e0e0 !important; transition: 0.3s; }
        .nav-link:hover { color: #f39c12 !important; transform: translateY(-2px); }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 10px; padding: 10px 25px; font-weight: 500; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102,126,234,0.4); }
        .btn-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none; border-radius: 10px; }
        .btn-danger { background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); border: none; border-radius: 10px; }
        table { background: white; border-radius: 15px; overflow: hidden; }
        th { background: #f8f9fa; font-weight: 600; }
        .footer { text-align: center; padding: 20px; color: #6c757d; margin-top: 40px; }
        .stat-card { background: white; border-radius: 20px; padding: 25px; text-align: center; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon { font-size: 40px; margin-bottom: 15px; }
        .stat-value { font-size: 32px; font-weight: 700; }
        .stat-label { color: #6c757d; font-size: 14px; margin-top: 5px; }
        .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .text-gradient { background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/index.php?r=site/index">
            <i class="fas fa-coins"></i> KassaPro
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (!Yii::$app->user->isGuest): ?>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=transaction/index"><i class="fas fa-list"></i> Операции</a></li>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=transaction/add"><i class="fas fa-plus-circle"></i> Добавить</a></li>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=category/index"><i class="fas fa-tags"></i> Категории</a></li>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=report/index"><i class="fas fa-chart-line"></i> Отчеты</a></li>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=profile/index"><i class="fas fa-user"></i> Профиль</a></li>
                <?php if (Yii::$app->user->identity->role == 'admin'): ?>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=admin/users"><i class="fas fa-users-cog"></i> Админка</a></li>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=log/index"><i class="fas fa-history"></i> Логи</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=site/logout" data-method="post"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=site/login"><i class="fas fa-sign-in-alt"></i> Вход</a></li>
                <li class="nav-item"><a class="nav-link" href="/index.php?r=site/register"><i class="fas fa-user-plus"></i> Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?= Yii::$app->session->getFlash('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?= $content ?>
</div>

<div class="footer">
    <div class="container">
        <p>© 2026 KassaPro — Система учета кассы организации</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
