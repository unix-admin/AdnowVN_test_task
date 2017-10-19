<?php

use app\models\Authors;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Books */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>
    <?php
        if ($model->preview){
            echo Html::img($model->preview,['width'=>'200px']);
        }
    ?>
    <?= $form->field($model, 'date')->widget(DatePicker::classname(),
        [
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-mm-yyyy']
        ]) ?>

    <?= $form->field($model, 'author_id')->dropDownList(ArrayHelper::map(Authors::find()->asArray()->all(),'id','firstname'),['prompt'=>'Выберите автора']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
