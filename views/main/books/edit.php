<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\helpers\Useful;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

$this->title = 'Книга';

?>

<div class="w-100 h-100 d-flex justify-content-center align-items-center">
    <div class="d-flex flex-column" style="width: 400px;">
        <h1 class="text-center fs-4"><?= Html::encode($this->title) ?></h1>

        <? if($model->coverImage): ?>
            <div style="width: 200px; height: 200px; background-image: url('<?= Useful::imgpatch($model->coverImage) ?>'); background-size: cover;" class="mx-auto"></div>
        <? else: ?>
            <div style="width: 200px; height: 200px; background-image: url('<?= Yii::getAlias('@web') ?>/images/emptyImage.png'); background-size: cover;" class="mx-auto"></div>
        <? endif; ?>

        <?php $form = ActiveForm::begin([
            'id' => 'book-update-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field($model, 'imageFile')->fileInput()->label('') ?>

        <?= $form->field($model, 'createdAt')->widget(DatePicker::classname(), [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => [
                'placeholder' => $model->createdAt ? Yii::$app->formatter->asDate($model->createdAt) : 'Год выпуска',
                'class'=> 'form-control',
                'autocomplete'=>'off'
            ],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '1800:2030',
            ]
        ])->label(false) ?>

        <?= $form->field($model, 'name')->textInput()->label('Название') ?>

        <?= $form->field($model, 'description')->textarea()->label('Описание') ?>

        <?= $form->field($model, 'isbn')->textInput()->label('ISBN') ?>

        <?= $form->field($model, 'authors')->dropDownList(ArrayHelper::map($authors,'id','surname'), ['multiple' => true])->label('Авторы'); ?>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'book-update-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>