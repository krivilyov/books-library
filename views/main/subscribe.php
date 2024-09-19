<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="w-100 h-100 d-flex justify-content-center align-items-center">
    <div class="d-flex flex-column" style="width: 400px;">
        <h1 class="text-center fs-4">Подписка</h1>
        <div class="mb-4 text-center">Телефон для уведомления через SMS</div>

        <?php $form = ActiveForm::begin([
            'id' => 'author-update-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field($model, 'phone')->textInput()->label(false) ?>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'author-update-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>