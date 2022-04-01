<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

$urlManger = \Yii::$app->urlManager;

$this->title = '导出数据';
$this->params['breadcrumbs'][] = ['label' => '厂商列表', 'url' => $urlManger->createUrl('supplier/index')];
$this->params['breadcrumbs'][] = $this->title;
//导出必选字段
$exportRequiredFields = ['id'];
?>
<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'export-form']); ?>
        <?= $form->field($model, 'fields')->inline()->checkboxList(['id' => 'id', 'name' => 'name', 'code' => 'code', 't_status' => 't_status'], [
            'item' => function ($i, $label, $name, $checked, $value) use ($exportRequiredFields) {
                $disabled = in_array($value, $exportRequiredFields) ? 'disabled' : '';
                $checkStr = $checked ? "checked" : "";

                return '<div class="custom-control custom-checkbox custom-control-inline">
<input type="checkbox" id="i' . $i . '" class="custom-control-input" name="' . $name . '" value="' . $value . '" ' . $checkStr . ' ' . $disabled . '><label class="custom-control-label" for="i' . $i . '">' . $label . '</label></div>';
            },
        ]) ?>
        <?= $form->field($model, 'condition')->label(false)->hiddenInput() ?>
        <div class="form-group">
            <?= Html::submitButton('确认', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    //    window.onload = function () {
    //        $('input[type="checkbox"]:first').attr('disabled', true)
    //    }
</script>
