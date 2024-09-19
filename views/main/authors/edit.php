<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\helpers\Useful;

$this->title = 'Автор';

?>

<div class="w-100 h-100 d-flex justify-content-center align-items-center">
    <div class="d-flex flex-column" style="width: 400px;">
        <h1 class="text-center fs-4"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'author-update-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field($model, 'surname')->textInput()->label('Фамилия') ?>

        <?= $form->field($model, 'name')->textInput()->label('Имя') ?>

        <?= $form->field($model, 'patronymic')->textInput()->label('Отчество') ?>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'author-update-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
