<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use app\models\Calendar;
use app\models\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $events = Event::find()->all();
        $calendarEvents = Calendar::makeCalendarEvents($events);

        if (Yii::$app->request->isAjax){
            return json_encode($calendarEvents);
        } else {
        return $this->render('index', [
            'calendarEvents' => $calendarEvents,
        ]);
    }
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date)
    {
        $model = new Event();
        $model->date = $date;

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSave()
    {
        if (empty($_POST['title']) || empty($_POST['date']) || empty($_POST['time'])) {
            return json_encode(['error' => 'Заполните все поля']);
        }

        if (Yii::$app->request->isAjax) {
            $model = (empty($_POST['id'])) ? new Event() : $this->findModel($_POST['id']);
            $model->title = $_POST['title'];
            $model->date = $_POST['date'];
            $model->time = $_POST['time'];

            if ($model->save()) {
                $events = Event::find()->all();
                $calendarEvents = Calendar::makeCalendarEvents($events);
                return json_encode($calendarEvents);
            } else {
                return json_encode(['error' => 'Что-то пошло не так']);
            }
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            if (!empty($_POST['id'])) {
                if($model = $this->findModel($_POST['id'])){
                    $modelToSend = json_encode(Event::find()->where(['id'=>$_POST['id']])->asArray()->one());
                    if($model->delete()){
                        return $modelToSend;
                    } else {
                        return json_encode(['error' => 'Что-то пошло не так']);
                    }
                }
            }
        }
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
