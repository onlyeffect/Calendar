<?php

use yii\helpers\Html;
use yii\grid\GridView;
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

    <?= 
        yii2fullcalendar\yii2fullcalendar::widget(array(
            'events' => $calendarEvents,
            'options' => [
                'lang' => 'ru',
            ],
            'clientOptions' => [
                'eventClick' => new JSExpression("function(eventObj) {
                    window.open(eventObj.url);
                    return false; // prevents browser from following link in current tab.
                }"),
            ],
        ));
    ?>
</div>
