<?php

class AuthorController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'billboard', 'subscription', 'index' and 'view' actions
                'actions'=>array('index','view', 'billboard', 'subscription'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
                'actions'=>array('create','update', 'admin','delete'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', [
            'model' => $this->loadModel($id),
            'isGuest' => Yii::app()->user->isGuest
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Author;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Author']))
        {
            $model->attributes=$_POST['Author'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Author']))
        {
            $model->attributes=$_POST['Author'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        try {            
            $this->loadModel($id)->delete();            

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } catch (LogicException $e) {
            header("HTTP/1.0 400 Relation Restriction");
            echo $e->getMessage() . ".\n";
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('Author');
        $this->render('index', [ 
            'dataProvider' => $dataProvider,
            'isGuest' => Yii::app()->user->isGuest
        ]);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Author('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Author']))
            $model->attributes=$_GET['Author'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Top - 10
     */
    public function actionBillboard(?int $id = null)
    {
        $year = $_POST['YearForm']['year'] ?? $id;
        if ($year) {
            $dataProvider = Author::model()->findTopOfYear($year);
            $this->render('billboard', [
                'dataProvider'=> $dataProvider,
                'year' => $year
            ]);
        } else {
            $model = new YearForm;
            $this->render('select-year', ['model' => $model]);
        }
    }

    public function actionSubscription(?int $id = null) {
        if (!$id) throw new CHttpException(404, 'Нужно указать id.');
        
        if (isset($_POST['SubscriptionForm'])) {
            $model = new Subscription;
            $model->attributes = $_POST['SubscriptionForm'];

            try {
                if ($model->save()) {
                    $this->redirect(['index']);
                } else {
                    print_r($model->getErrors());
                }
            } catch (CDbException $e) {
                throw new Exception('Ошибка при сохранении модели. ' . $e->getMessage());
            } catch (Exception $e) {
                Yii::log("General exception during model save: " . $e->getMessage(), 'error');
                echo "An unexpected error occurred.";
            }

        } else {
            $model = new SubscriptionForm;
            $this->render('subscription', ['model' => $model, 'authorId' => $id]);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Author the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Author::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Author $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='author-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}