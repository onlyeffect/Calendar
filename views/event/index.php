<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php 
        Modal::begin([
            'id' => 'modal',
            'size' => 'modal-lg'
        ]);

        echo '<div id=\'modalContent\'></div>';

        Modal::end();
    ?>

    <?= 
        yii2fullcalendar\yii2fullcalendar::widget(array(
            'events' => $calendarEvents,
            'options' => [
                'lang' => 'ru',
            ],
            'clientOptions' => [
                'eventClick' => new JSExpression("function(eventObj) {
                    $.get('event/update', {'id': eventObj.id}, function(data){
                        $('#modal').modal('show')
                        .find('#modalContent')
                        .html(data);
                    });
                }"),
            ],
        ));
    ?>
</div>
