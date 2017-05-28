<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
    
    /** Use static pages (without controllers action)
     * 
     */
    public function actions() {
        return array(
        // page action renders "static" pages stored under 'protected/views/site/pages'
        // They can be accessed via: index.php?r=site/page&view=FileName
        'page' => array('class' => 'CViewAction', ), );
    }
    

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('create','resetPassword','page',),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('update','changePassword','view','edit'),
						'users'=>array('@'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('admin','index','delete'),
						'expression'=>"Yii::app()->user->isAdmin()",
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

	/** Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id=0)
	{
		if(!Yii::app()->user->isAdmin())
			$id=Yii::app()->user->getId();
		$this->render('view',array(
				'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$user_model=new User('create');
		
		//$user_model->scenario='create';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$user_model->attributes=$_POST['User'];
			$valid=$user_model->validate();
			if($valid)
			{
			$form=new LoginForm();
			$form->username=$user_model->username;
			$form->password=$user_model->password;
			
			$user_model->save();
			$form->rememberMe=false;
				if(!Yii::app()->user->isAdmin()){
					$form->login();
				}

				$this->redirect(array('site/index'));

			}
		}

		$this->render('create',array(
				'user_model'=>$user_model,
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

		if(isset($_POST['User']))
		{
			$model->role_id=$_POST['User']['role_id'];
			$model->approved=$_POST['User']['approved'];
			if($model->update()){
				Yii::app()->user->setFlash('message','Changes saved!');
				$this->redirect(array('admin'));
			}
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
		if(!Yii::app()->user->isAdmin()&&$this->loadModel($id)->id!=Yii::app()->user->loadUser()->id)
			Yii::app()->end();
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User',array('pagination'=>array('pageSize'=>14)));
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
				'model'=>$model,
		));
	}
	/** Changes the password of a user.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionChangePassword($id){
		if(!Yii::app()->user->isAdmin()||Yii::app()->user->loadUser()->user_id===$id){
			$id=Yii::app()->user->getId();
			$model=$this->loadModel($id);
			$model->scenario='changePassword';
		}
		else
		{
			$model=$this->loadModel($id);
			$model->scenario='adminChangePassword';
		}
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()){
				Yii::app()->user->setFlash('message','Password Changed!');
				$this->redirect(array('view','id'=>$model->user_id));
			}
		}

		$this->render('changePassword',array('model'=>$model));

	}
    
   

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionDummy()
	{	
		
		$this->render('dummy');
	}
	
		public function actionEdit()
		{
			$user_model=Yii::app()->user->loadUser();
			$id=$_GET['id'];
			
			if(isset($_POST['User']))
			{
				$user_model->attributes=$_POST['User'];
				if($user_model->save())
				{
					Yii::app()->user->setFlash('message','Password Changed!');
					$this->redirect(array('site/index'));
				}
			}
			$this->render('edit',array('user_model'=>$user_model
		));
		}
}
