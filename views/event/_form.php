<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">
    <div id="error" class="alert alert-danger" hidden></div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput(['id' => 'model_id'])->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'id' => 'title']) ?>

    <?= $form->field($model, 'date')->widget(DateTimePicker::className(), [
            'pluginOptions' => [
                'format'=> 'yyyy-m-d hh:ii:00',
            ],
        ]);
    ?>

    <div class="form-group">
        <?= Html::button('Save', ['id' => 'btnSave', 'class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$('#btnSave').on('click', function(){
    $.ajax({
        url: '/event/save',
        type: 'post',
        data: {
            id: $('#model_id').val(),
            title: $('#title').val(), 
            date: $('#event-date').val(),
        },
        success: function (data) {
            var data = JSON.parse(data);
            if(data.error){
                $('#error').html(data.error);
                $('#error').show();
                return false;
            }
            $('#modal').modal('hide');
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('renderEvents', data);
        },
    });
});

$('#btnDelete').on('click', function(){
    if (confirm('Вы уверены, что хотите удалить событие?')){
        $.ajax({
            url: '/event/delete',
            method: 'post',
            data: {
                id: $('#model_id').val(),
            },
            success: function (data) {
                var data = JSON.parse(data);
                if(data.error){
                    $('#error').html(data.error);
                    $('#error').show();
                    return false;
                }
                $('#modal').modal('hide');
                $('#calendar').fullCalendar('removeEvents', data.id);
            },
        });
    }
});
</script>