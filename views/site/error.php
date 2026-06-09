<?php
use yii\helpers\Html;
$this->title = 'Ошибка';
?>

<div style="text-align: center; padding: 60px;">
    <i class="fas fa-exclamation-triangle" style="font-size: 64px; color: #ef4444; margin-bottom: 20px; display: block;"></i>
    <h1>Ошибка <?= $exception->statusCode ?></h1>
    <p style="color: #6b7280; margin: 20px 0;"><?= nl2br(Html::encode($exception->getMessage())) ?></p>
    <a href="?r=site/index" class="btn btn-primary">На главную</a>
</div>
