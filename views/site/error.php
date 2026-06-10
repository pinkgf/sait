<?php
$this->title = 'Ошибка';
?>
<div class="text-center" style="margin-top: 100px;">
    <h1>Ошибка <?= $exception->statusCode ?></h1>
    <p><?= nl2br($exception->getMessage()) ?></p>
    <a href="/index.php?r=site/index" class="btn btn-primary">На главную</a>
</div>
