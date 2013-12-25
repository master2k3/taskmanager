<?php
/**
 * @var yii\base\View $this
 * @var app\modules\tasks\models\Task $model
 */

use yii\helpers\Html;
use yii\widgets\Menu;

use app\modules\comments\widgets\comments\Comments;

$this->title = "Просмотр задачи";
?>
<div class="row">
	<?php if (!Yii::$app->user->isGuest) { ?>
		<div class="span3">
			<?php echo Menu::widget(array(
				'options' => array('class' => 'nav nav-pills nav-justified'),
				'items' => array(
// 					array(
// 						'label' => 'Меню пользователя',
// 						'itemOptions' => array('class' => 'nav-header')
// 					),
					array(
						'label' => 'Список задач',
						'url' => array('/tasks')
					),
					array(
						'label' => 'Новая задача',
						'url' => array('/tasks/default/create')
					),
					array(
						'label' => 'Изменить задачу',
						'url' => array(
							'/tasks/default/edit',
							'id' => $model['id']
						),
						'visible' => (Yii::$app->user->checkAccess('editOwnTask', array('task' => $model)) || Yii::$app->user->checkAccess('editTask'))
					),
					array(
						'label' => 'Удалить задачу',
						'url' => array(
							'/tasks/default/delete',
							'id' => $model['id']
						),
						'visible' => (Yii::$app->user->checkAccess('deleteOwnTask', array('task' => $model)) || Yii::$app->user->checkAccess('deleteTask'))
					)
				)
			)); ?>
		</div>
	<?php } ?>
	<div class="<?php echo Yii::$app->user->isGuest ? 'span12' : 'span9'; ?>">
		<div class="page-header">
			<h1><?php echo Html::encode($this->title); ?></h1>
		</div>
		<p><b>Статус</b>: <? echo $req['status'];?></p>
		<p><b>Инициатор</b>: <? echo $req['init'];?></p>
		<p><b>Исполнитель</b>: <? echo $req['dev'];?></p>
		<p><b>Дата постановки</b>: <?=$model['create_time'];?></p>
		<p><b>Дата исполнения</b>: <?=$model['expiration_time'];?></p>
		<h3>Описание</h3>
		<blockquote><?php echo $model['content']; ?></blockquote>
		<?php echo Comments::widget(array('model' => $model)); ?>
	</div>
</div>