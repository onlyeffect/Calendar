<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Календарь событий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">
    <h1><?= Html::encode($this->title) ?></h1>

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
            'id' => 'calendar',
            'events' => $calendarEvents,
            'options' => [
                'lang' => 'ru',
            ],
            'clientOptions' => [
                'displayEventTime' => false,
                'eventClick' => new JSExpression("function(eventObj) {
                    $.get('event/update', {'id': eventObj.id}, function(data){
                        $('#modal').modal('show')
                        .find('#modalContent')
                        .html(data);
                    });
                }"),
                'dayClick' => new JSExpression("function(date) {
                    var date = date.format();
                    $.get('event/create', {'date': date}, function(data){
                        $('#modal').modal('show')
                        .find('#modalContent')
                        .html(data);
                    });
                }"),
            ],
        ));
    ?>
</div>
