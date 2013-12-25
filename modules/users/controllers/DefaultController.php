<?php
namespace app\modules\users\controllers;

use Yii;
use yii\web\HttpException;
use yii\data\Pagination;

use app\modules\site\components\FController;
use app\modules\users\models\User;
use app\modules\users\models\LoginForm;

class DefaultController extends FController
{
	public function behaviors()
	{
		return array(
			'access' => array(
				'class' => \yii\web\AccessControl::className(),
				'rules' => array(
				    // allow authenticated users
					array(
						'allow' => true,
						'actions' => array('login', 'activation'),
						'roles' => array('?')
					),
					array(
						'allow' => true,
						'actions' => array('index', 'view', 'logout', 'edit', ),
						'roles' => array('@')
					),
					array(
						'allow' => true,
						'actions' => array('create', 'delete'),
						'roles' => array(USER::ROLE_ADMIN)
					),
					// deny all
					array(
						'allow' => false
					)
				)
			)
		);
	}
	
	public function actionIndex()
	{
		$query = User::find()->asArray();
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$pages->pageSize = $this->module->recordsPerPage;
		$models = $query->offset($pages->offset)
		          ->limit($pages->limit)
		          ->all();
		echo $this->render('index', array(
			'models' => $models,
			'pages' => $pages,
		));
	}

	public function actionView($username)
	{
		if ($model = User::findByUsername($username))
			echo $this->render('view', array('model' => $model));
		else
			throw new HttpException(404);
	}

	public function actionEdit($username)
	{
		if ($model = User::findByUsername($username)) {
			if (Yii::$app->user->checkAccess('editOwnProfile', array('user' => $model)) || Yii::$app->user->checkAccess('editProfile')) {
				$model->scenario = 'update';
				if ($model->load($_POST)) {
					if ($model->save()) {
						Yii::$app->session->setFlash('success');
						return Yii::$app->response->refresh();
					}
				} else {
					echo $this->render('edit', array('model' => $model));
				}
			} else {
				throw new HttpException(403);
			}
		} else {
			throw new HttpException(404);
		}
	}

	public function actionDelete($username)
	{
		if ($model = User::findByUsername($username)) {
			if (Yii::$app->user->checkAccess('deleteOwnProfile', array('user' => $model)) || Yii::$app->user->checkAccess('deleteProfile')) {
				$model->status = User::STATUS_DELETED;
				if ($model->save())
					return Yii::$app->response->redirect(array('users'));
			} else {
				throw new HttpException(403);
			}
		} else {
			throw new HttpException(500);
		}
	}

	public function actionLogin()
	{
		$model = new LoginForm();
		if ($model->load($_POST) && $model->login()) {
			return Yii::$app->response->redirect(array('site/default/index'));
		} else {
			echo $this->render('login', array('model' => $model));
		}
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();
		return Yii::$app->response->redirect(array('site/default/index'));
	}

	public function actionCreate()
	{
		$model = new User();
		$model->scenario = 'create';
		if ($model->load($_POST)) {
			if (!$this->module->activeAfterRegistration)
				$model->on($model::EVENT_NEW_USER, array($this->module, 'onNewUser'));
			if ($model->save()) {
				Yii::$app->session->setFlash('success');
				return Yii::$app->response->refresh();
			}
		} else {
			echo $this->render('create', array('model' => $model));
		}
	}

	public function actionActivation($username, $key)
	{
		if ($model = User::find(array('username' => $username, 'activkey' => $key))) {
			$model->scenario = 'activation';
			$model->status = User::STATUS_ACTIVE;
			if ($model->save()) {
				Yii::$app->session->setFlash('success');
				Yii::$app->response->refresh();
			}
		}
		echo $this->render('activation');
	}
}