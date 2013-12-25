<?php
namespace app\modules\tasks\controllers;

use Yii;
use yii\web\HttpException;
use yii\data\Pagination;
use yii\base\Formatter;

use app\modules\site\components\FController;
use app\modules\tasks\models\Task;
use app\modules\users\models\User;

class DefaultController extends FController
{
	public function behaviors()
	{
		return array(
			'access' => array(
				'class' => \yii\web\AccessControl::className(),
				'only' => array('create', 'edit', 'delete'),
				'rules' => array(
				    // allow authenticated users
					array(
						'allow' => true,
						'roles' => array(User::ROLE_USER)
					),
					// deny all
					array(
						'allow' => false
					)
				)
			)
		);
	}
	
	public function getStatuses()
	{
		$status = array();
		foreach(array(Task::STATUS_NEW, Task::STATUS_PROCESSING, Task::STATUS_DONE, Task::STATUS_CLOSED) as $s)
			{
			  $status[$s] = Task::getStatusName($s);
			}
		return $status;
	}

	public function actionIndex($status = false)
	{
		$query = Task::find();
		if ($status!==false)
		{
		  $query -> where(array('status' => $status));
		}
		$query -> asArray();
		
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$pages->pageSize = $this->module->recordsPerPage;
		$models = $query->offset($pages->offset)
		          ->limit($pages->limit)
		          ->all();
		echo $this->render('index', array(
			'models' => $models,
			'pages' => $pages,
			'status' => $this->getStatuses(),
		));
	}

	public function actionView($id) {
		$model = Task::find($id);
		$Formatter = new Formatter();
		$model->create_time = $Formatter->asDate($model->create_time,'d.m.Y');
		
		$users = User::findIdentity($model->author_id);
		$req['init'] = $users->realname;

		$users = User::findIdentity($model->user_id);
		$req['dev'] = $users->realname;
		
		$req['status'] = Task::getStatusName($model->status);

		$model->expiration_time = $Formatter->asDate($model->expiration_time,'d.m.Y');
		echo $this->render('view', array('model' => $model,'req'=>$req));
	}

	public function actionCreate()
	{
		$model = new Task();
		if ($model->load($_POST)) {
			if ($model->save())
				return Yii::$app->response->redirect(array('/tasks/view', 'id' => $model->id));
		} else {
		
			$users = User::find()->all();
			
			echo $this->render('create', array('model' => $model, 'users' => $users, 'status' => $this->getStatuses()));
		}
	}

	public function actionEdit($id)
	{
		if ($model = Task::find($id)) {
			if (Yii::$app->user->checkAccess('editOwnTask', array('task' => $model)) || Yii::$app->user->checkAccess('editTask')) {
				if ($model->load($_POST)) {
					if ($model->save())
						return Yii::$app->response->redirect(array('/tasks/view', 'id' => $model->id));
				} else {
					$users = User::find()->all();
					$Formatter = new Formatter();
					$model->expiration_time = $Formatter->asDate($model->expiration_time,'d.m.Y');
					echo $this->render('edit', array('model' => $model, 'users' => $users, 'status' => $this->getStatuses()));
				}
			} else {
				throw new HttpException(403);
			}
		} else {
			throw new HttpException(404);
		}
	}

	public function actionDelete($id)
	{
		if ($model = Task::find($id)) {
			if (Yii::$app->user->checkAccess('deleteOwnTask', array('task' => $model)) || Yii::$app->user->checkAccess('deleteTask')) {
				if ($model->delete())
					return Yii::$app->response->redirect(array('/tasks'));
			} else {
				throw new HttpException(403);
			}
		} else {
			throw new HttpException(404);
		}
	}
}