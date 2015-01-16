<?php

class UsuarioController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'ajaxsearch'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $model = Usuario::model()
                ->with('sexo')
                ->with('identidad')
                ->findByPk($id);

        $model->setAttribute('fecha_nacimiento', $this->stringFormat->applyFecha($model->getAttribute('fecha_nacimiento')));
        $this->render('view', array(
            'model' => $model
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Usuario;

        if (isset($_POST['Usuario'])) {
            $model->attributes = $_POST['Usuario'];
            $model->setAttribute('fecha_nacimiento', $this->stringFormat->clearFecha($_POST['Usuario']['fecha_nacimiento']));
                    if($_POST['Usuario']['identidad_id'] == 1){
                            $rut = Yii::app()->rut->deleteFormat($_POST['Usuario']['rut']);
                            $model->setAttribute('rut',Yii::app()->rut->addFormat($rut));
                    }
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->usuario_id));
            }
        }

        $DateTime = new DateTime('NOW');
        $model->fecha_creacion = $DateTime->format('Y-m-d H:i:s');

        $listTipoFuenteIngreso = CHtml::listData(TipoFuenteIngreso::model()->findAll(), 'tipo_fuente_ingreso_id', 'titulo');

        $this->render('create', array(
            'model' => $model,
            'listTipoFuenteIngreso' => $listTipoFuenteIngreso
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Usuario'])) {
            $model->attributes = $_POST['Usuario'];
            $model->setAttribute('fecha_nacimiento', $this->stringFormat->clearFecha($_POST['Usuario']['fecha_nacimiento']));
                if($_POST['Usuario']['identidad_id'] == 1){
                        $rut = Yii::app()->rut->deleteFormat($_POST['Usuario']['rut']);
                        $model->setAttribute('rut',Yii::app()->rut->addFormat($rut));
                }
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->usuario_id));
        }

        $model->setAttribute('fecha_nacimiento', $this->stringFormat->applyFecha($model->getAttribute('fecha_nacimiento')));
        $listTipoFuenteIngreso = CHtml::listData(TipoFuenteIngreso::model()->findAll(), 'tipo_fuente_ingreso_id', 'titulo');

        $this->render('update', array(
            'model' => $model,
            'listTipoFuenteIngreso' => $listTipoFuenteIngreso
        ));
    }

    public function actionAjaxSearch($id) {

        $rut = Yii::app()->rut->addFormat($id);

        $criteria = new CDbCriteria;
        $criteria->compare('rut', $rut);

        $Usuario = Usuario::model()->find($criteria);

        if ($Usuario === null) {
            $response = array(
                'usuario_id' => 0
            );
        } else {
            $response = array(
                'usuario_id' => $Usuario->usuario_id
            );
        }

        $this->layout = false;
        echo CJSON::encode($response);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->redirect(array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Usuario('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Usuario']))
            $model->attributes = $_GET['Usuario'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Usuario the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Usuario::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Usuario $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'usuario-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
