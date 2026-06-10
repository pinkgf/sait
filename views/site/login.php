<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Вход в систему';
?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">🔐 Вход в систему</h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>
                
                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
                
                <?= $form->field($model, 'rememberMe')->checkbox(['label' => 'Запомнить меня']) ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block', 'style' => 'width:100%']) ?>
                </div>
                
                <?php ActiveForm::end(); ?>
                
                <hr>
                <div class="text-center">
                    Нет аккаунта? <?= Html::a('Зарегистрироваться', ['site/register']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
